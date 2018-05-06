<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
//Route::post('/register',function(Request $request){
//    return $request->input();
//});

Route::post('/register','RegisterController@register');

Route::get('/sms','RegisterController@sms');

Route::post('/login','RegisterController@login');

Route::post('/changePassword','RegisterController@changePassword');

Route::post('/forgetPassword','RegisterController@forgetPassword');

Route::post('/addAddress','AddressController@addAddress');

Route::get('/addressList','AddressController@addressList');

Route::post('/editAddress','AddressController@editAddress');

Route::get('/address','AddressController@address');

Route::get('/addressDelete','AddressController@addressDelete');

Route::post('/addCart','CartController@addCart');

Route::get('/cart','CartController@cart');

Route::post('/addOrder','OrderController@addOrder');

Route::get('/orderList','OrderController@orderList');

Route::get('/orders','OrderController@orders');

Route::get('/orderList','OrderController@orderList');
//Route::get('/sms',function (){
//    $params = array ();
//
//    // *** 需用户填写部分 ***
//
//    // fixme 必填: 请参阅 https://ak-console.aliyun.com/ 取得您的AK信息
//    $accessKeyId = "LTAIW8ca7wm9wjSX";
//    $accessKeySecret = "RCmTzXIhfViT4Pssk1qJOfGD1DuMNr";
//
//    // fixme 必填: 短信接收号码
//    $params["PhoneNumbers"] = "17761401443";
//
//    // fixme 必填: 短信签名，应严格按"签名名称"填写，请参考: https://dysms.console.aliyun.com/dysms.htm#/develop/sign
//    $params["SignName"] = "朝石锅拌饭";
//
//    // fixme 必填: 短信模板Code，应严格按"模板CODE"填写, 请参考: https://dysms.console.aliyun.com/dysms.htm#/develop/template
//    $params["TemplateCode"] = "SMS_133845010";
//
//    // fixme 可选: 设置模板参数, 假如模板中存在变量需要替换则为必填项
//    $params['TemplateParam'] = Array (
//        "code" => mt_rand(100000,999999),
////        "product" => "阿里通信"
//    );
//
//    // fixme 可选: 设置发送短信流水号
////    $params['OutId'] = "12345";
//
//    // fixme 可选: 上行短信扩展码, 扩展码字段控制在7位或以下，无特殊需求用户请忽略此字段
////    $params['SmsUpExtendCode'] = "1234567";
//
//
//    // *** 需用户填写部分结束, 以下代码若无必要无需更改 ***
//    if(!empty($params["TemplateParam"]) && is_array($params["TemplateParam"])) {
//        $params["TemplateParam"] = json_encode($params["TemplateParam"], JSON_UNESCAPED_UNICODE);
//    }
//
//    // 初始化SignatureHelper实例用于设置参数，签名以及发送请求
//    $helper = new \App\Sms();
//
//    // 此处可能会抛出异常，注意catch
//    $content = $helper->request(
//        $accessKeyId,
//        $accessKeySecret,
//        "dysmsapi.aliyuncs.com",
//        array_merge($params, array(
//            "RegionId" => "cn-hangzhou",
//            "Action" => "SendSms",
//            "Version" => "2017-05-25",
//        ))
//    // fixme 选填: 启用https
//    // ,true
//    );
//
////    dd($content);
//    if ($content->Message == 'OK'){
//        echo'{
//        "status":"false",
//        "message":"短信发送成功"
//        }';
//    }else{
//        echo'{
//        "status":"false",
//        "message":"短信发送失败,请稍后试试"
//        }';
//    }
//});