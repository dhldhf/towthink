<?php

namespace App\Http\Controllers;

use App\Order;
use App\Order_goods;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{

    public function order(Request $request)
    {
//        var_dump($request->id);die;
   $order = DB::table('orders')->where('id','=',$request->id)->first();
//   var_dump($order);die;
   $goods_list = [];
       $Order_goods = DB::table('Order_goods')->where('order_id','=',$order->id)->first();
       $foods = DB::table('foods')->where('goods_id','=',$Order_goods->goods_id)->first();
        $foods->amount = 1;
       $goods_list[] = $foods;
//   var_dump()
        $order->goods_list = $goods_list;
        return json_encode($order);
    }

    public function addOrder(Request $request)
    {
        $address = DB::table('addresses')->where('id','=',$request->address_id)->first();
        $cart =  DB::table('carts')->where('user_id','=',$address->user_id)->first();
        $foods =  DB::table('foods')->where('goods_id','=',$cart->goodsList)->first();
        $information =  DB::table('information')->where('id','=',$foods->shop_id)->first();
        $a = date('YmdHis').uniqid();
        DB::transaction(function ()use($information,$foods,$cart,$address,$a) {
            $order = Order::create(
                [
                    'order_code'=>$a,
                    'order_birth_time'=>date('Y-m-d H:i:s',time()),
                    'shop_id'=>$information->id,
                    'shop_name'=>$information->shop_name,
                    'shop_img'=>$information->shop_img,
                    'provence'=>$address->provence,
                    'city'=>$address->city,
                    'area'=>$address->area,
                    'order_address'=>$address->detail_address,
                    'name'=>$address->name,
                    'tel'=>$address->tel,
                    'user_id'=>Auth::user()->id,
                    'order_price'=>$cart->goodsCount*$foods->goods_price,
                ]
            );
//            dd($order->id);
            Order_goods::create(
                [
                    'order_id'=>$order->id,
                    'goods_id'=>$foods->goods_id,
                    'amount'=>$cart->goodsCount,
                    'goods_name'=>$foods->goods_name,
                    'goods_price'=>$foods->goods_price,
                    'goods_img'=>$foods->goods_img,
                ]
            );
        });
        $orders = DB::table('orders')->where('order_code','=',$a)->first();
//        dd($orders->id);
       return [
            "status"=> "true",
            "message"=> "添加成功",
            "order_id"=>$orders->id
            ];
    }

    public function orderList()
    {
        $order = DB::table('orders')->where('user_id','=',Auth::user()->id)->get();
//        var_dump($order);die;
        $goods_list = [];
        $money = 0;
        foreach ($order as $or){
            $Order_goods = DB::table('Order_goods')->where('order_id','=',$or->id)->first();
            $foods = DB::table('foods')->where('goods_id','=',$Order_goods->goods_id)->first();
            $money += $foods->goods_price;
            $goods_list[] = $foods;
            $or->goods_list = $goods_list;
            $or->order_price = $money;
//            var_dump($goods_list);die;
        }

//   var_dump()

        return json_encode($order);
    }
}
