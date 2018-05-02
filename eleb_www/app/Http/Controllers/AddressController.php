<?php

namespace App\Http\Controllers;

use App\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AddressController extends Controller
{
    public function addressList(Request $request)
    {
//        return $request->input();
        $addresses = DB::table('addresses')->where('user_id', '=',Auth::user()->id)->get();
//        $addresses = Address::all()->where('user_id',Auth::user()->id);
       return $addresses;
    }

    public function create()
    {
        //
    }

    public function addAddress(Request $request)
    {
//        return $request->input();
       $validator = Validator::make($request->all(),
           [
            'tel' => [
                'required',
                'regex:/^0?(13|14|15|17|18|19)[0-9]{9}$/',
                ]
            ],
           [
                'tel.regex'=>'手机号格式不正确',
            ]
       );
        if ($validator->fails()) {
            $errors = $validator->errors();
            return [
                "status"=> "false",
                "message"=> $errors->first()
            ];
        }
        Address::create(
            [
                'name'=>$request->name,
                'tel'=>$request->tel,
                'provence'=>$request->provence,
                'city'=>$request->city,
                'area'=>$request->area,
                'detail_address'=>$request->detail_address,
                'user_id'=>Auth::user()->id,
            ]
        );
        return [
            "status"=> "true",
            "message"=> "注册成功"
        ];
    }

    public function show(Address $address)
    {
        //
    }

    public function address(Request $request)
    {
               $addresses = Address::find($request->id);
                return $addresses;
    }

    public function editAddress(Request $request)
    {
        DB::table('addresses')
            ->where('id', $request->id)
            ->update([
                'name'=>$request->name,
                'tel'=>$request->tel,
                'provence'=>$request->provence,
                'city'=>$request->city,
                'area'=>$request->area,
                'detail_address'=>$request->detail_address,
                    ]
            );
        return [
            "status"=> "true",
            "message"=> "修改成功"
        ];
    }

    public function update(Request $request, Address $address)
    {
        //
    }

    public function addressDelete(Request $request)
    {
        DB::table('addresses')->where('id','=',$request->id)->delete();
        return [
            "status"=> "true",
            "message"=> "删除成功"
        ];
    }

}
