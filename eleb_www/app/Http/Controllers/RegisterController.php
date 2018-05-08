<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redis;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
//        dd($request->tel);
       $code =  Redis::get('code'.$request->tel);
        if ($code != $request->sms){
            return [
                "status"=> "false",
                "message"=> "验证码错误"
            ];
        }
        User::create(
            [
                'name'=>$request->username,
                'password'=>bcrypt($request->password),
                'tel'=>$request->tel,
            ]
        );
        return [
                "status"=> "true",
                "message"=> "注册成功"
        ];
    }

    public function login(Request $request)
    {
//        echo 123;die;
        if (Auth::attempt(['name'=>$request->name,'password'=>$request->password,])){
            return json_encode([
                "status"=>"true",
                "message"=>"登录成功",
                "user_id"=>$request->id,
                "username"=>$request->name
            ]);
        }else{
            return json_encode([
                "status"=>"false",
                "message"=>"登录失败,用户名或密码失败",
                "user_id"=>$request->id,
                "username"=>$request->name
            ]);
        }
    }

    public function sms(Request $request)
    {
        $params = array ();

        // *** 需用户填写部分 ***

        // fixme 必填: 请参阅 https://ak-console.aliyun.com/ 取得您的AK信息
        $accessKeyId = "LTAIW8ca7wm9wjSX";
        $accessKeySecret = "RCmTzXIhfViT4Pssk1qJOfGD1DuMNr";

        // fixme 必填: 短信接收号码
        $params["PhoneNumbers"] = $request->tel;

        // fixme 必填: 短信签名，应严格按"签名名称"填写，请参考: https://dysms.console.aliyun.com/dysms.htm#/develop/sign
        $params["SignName"] = "朝石锅拌饭";

        // fixme 必填: 短信模板Code，应严格按"模板CODE"填写, 请参考: https://dysms.console.aliyun.com/dysms.htm#/develop/template
        $params["TemplateCode"] = "SMS_133845010";

        // fixme 可选: 设置模板参数, 假如模板中存在变量需要替换则为必填项
        $code =  mt_rand(100000,999999);
        $params['TemplateParam'] = Array (
            "code" =>$code,
//        "product" => "阿里通信"
        );
        Redis::setex('code'.$request->tel,600,$code);
//        dd(Redis::get('code'.$request->tel));
        // fixme 可选: 设置发送短信流水号
//    $params['OutId'] = "12345";

        // fixme 可选: 上行短信扩展码, 扩展码字段控制在7位或以下，无特殊需求用户请忽略此字段
//    $params['SmsUpExtendCode'] = "1234567";


        // *** 需用户填写部分结束, 以下代码若无必要无需更改 ***
        if(!empty($params["TemplateParam"]) && is_array($params["TemplateParam"])) {
            $params["TemplateParam"] = json_encode($params["TemplateParam"], JSON_UNESCAPED_UNICODE);
        }

        // 初始化SignatureHelper实例用于设置参数，签名以及发送请求
        $helper = new \App\Sms();

        // 此处可能会抛出异常，注意catch
        $content = $helper->request(
            $accessKeyId,
            $accessKeySecret,
            "dysmsapi.aliyuncs.com",
            array_merge($params, array(
                "RegionId" => "cn-hangzhou",
                "Action" => "SendSms",
                "Version" => "2017-05-25",
            ))
        // fixme 选填: 启用https
        // ,true
        );

//        dd($content);
        if ($content->Message == 'OK'){
            echo'{
        "status":"false",
        "message":"短信发送成功"
        }';
        }else{
            echo'{
        "status":"false",
        "message":"短信发送失败,请稍后试试"
        }';
        }
    }

    public function changePassword(Request $request)
    {
        if (Hash::check($request->oldPassword,Auth::user()->password)) {
            DB::table('users')
            ->where('id',Auth::user()->id)
                ->update(['password' =>bcrypt($request->newPassword)]);
            return [
                "status"=>"true",
                "message"=> "修改成功"
            ];
        }else{
            return [
                "status"=>"false",
                "message"=> "修改失败,旧密码错误"
            ];
        }

    }

    public function forgetPassword(Request $request)
    {
//        echo 234;
//        return $request->input();
        $code =  Redis::get('code'.$request->tel);
        if ($code == $request->sms){
            DB::table('users')
                ->where('tel',$request->tel)
                ->update(['password' =>bcrypt($request->password)]);
            return [
                "status"=>"true",
                "message"=> "修改成功"
            ];
        }else{
            return [
                "status"=> "false",
                "message"=> "修改密码失败"
            ];
        }

    }
}
