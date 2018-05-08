<?php

namespace App\Http\Controllers;

use App\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function index()
    {
        //
    }

    public function create()
    {

    }

    public function addCart(Request $request)
    {
        DB::table('carts')->where('user_id','=',Auth::user()->id)->delete();
//       dd($request);
        $sb = $request->goodsList;
        $bs = $request->goodsCount;
        foreach ($sb as $key => $goodsList){
            Cart::create(
                [
                    'goodsList'=>$goodsList,
                    'goodsCount'=>$bs[$key],
                    'user_id'=>Auth::user()->id,
                ]
            );
        }
        return[
            "status"=> "true",
      "message"=> "添加成功"
                ];
    }

    public function cart(Request $request)
    {
       $cart = DB::table('carts')->where('user_id','=',Auth::user()->id)->get();
//       var_dump($cart);die;
       $foods_list = [];
       $count = 0;
       foreach ($cart as $list){
           $foods = DB::table('foods')->where('goods_id','=',$list->goodsList)->first();
           $foods->amount=$list->goodsCount;
           $foods->count=$foods->goods_price*$foods->amount;
           $count+=$foods->count;
           $foods_list[] = $foods;
       }
        $cart_list['totalCost'] = $count;
        $cart_list['goods_list'] = $foods_list;
//       dd($foods_list);
        return $cart_list;
    }

    public function edit(Cart $cart)
    {
        //
    }

    public function update(Request $request, Cart $cart)
    {
        //
    }

    public function destroy(Cart $cart)
    {
        //
    }
}
