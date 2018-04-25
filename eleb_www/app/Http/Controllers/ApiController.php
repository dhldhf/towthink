<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiController extends Controller
{
    public function show()
    {
        $shops = DB::table('information')->get();
//        dd($shops);
        foreach ($shops as $shop){
            $shop->distance = 637;
        }
        return $shops;
//        echo <<<JSON
//    [
//      {
//        "id": "s10001",
//        "shop_name": "上沙麦当劳",
//        "shop_img": "http://www.homework.com/images/shop-logo.png",
//        "shop_rating": 4.7,
//        "brand": true,
//        "on_time": true,
//        "fengniao": true,
//        "bao": true,
//        "piao": true,
//        "zhun": true,
//        "start_send": 20,
//        "send_cost": 5,
//        "distance": 637,
//        "estimate_time": 30,
//        "notice": "新店开张，优惠大酬宾！",
//        "discount": "新用户有巨额优惠！"
//      },
//      {
//        "id": "s10002",
//        "shop_name": "正宗川味卤鸡蛋，味道好得很！",
//        "shop_img": "http://www.homework.com/images/shop-logo.png",
//        "shop_rating": 3.5,
//        "brand": false,
//        "on_time": true,
//        "fengniao": false,
//        "bao": true,
//        "piao": false,
//        "zhun": true,
//        "start_send": 20,
//        "send_cost": 0,
//        "distance": 347,
//        "estimate_time": 20,
//        "notice": "新店开张，优惠大酬宾！",
//        "discount": "新用户有巨额优惠！"
//      },
//      {
//        "id": "s10003",
//        "shop_name": "有家蛋糕店（下沙店）",
//        "shop_img": "http://www.homework.com/images/shop-logo.png",
//        "shop_rating": 4.4,
//        "brand": false,
//        "on_time": true,
//        "fengniao": false,
//        "bao": true,
//        "piao": false,
//        "zhun": true,
//        "start_send": 80,
//        "send_cost": 0,
//        "distance": 637,
//        "estimate_time": 30,
//        "notice": "新店开张，优惠大酬宾！",
//        "discount": "新用户有巨额优惠！"
//      },
//      {
//        "id": "s10004",
//        "shop_name": "宇宙炸鸡（上沙店）",
//        "shop_img": "http://www.homework.com/images/shop-logo.png",
//        "shop_rating": 4.3,
//        "brand": true,
//        "on_time": false,
//        "fengniao": false,
//        "bao": true,
//        "piao": false,
//        "zhun": true,
//        "start_send": 20,
//        "send_cost": 5,
//        "distance": 127,
//        "estimate_time": 10,
//        "notice": "新店开张，优惠大酬宾！",
//        "discount": "新用户有巨额优惠！"
//      },
//      {
//        "id": "s10005",
//        "shop_name": "胖哥烧烤（车公庙店）",
//        "shop_img": "http://www.homework.com/images/shop-logo.png",
//        "shop_rating": 4.6,
//        "brand": false,
//        "on_time": false,
//        "fengniao": false,
//        "bao": true,
//        "piao": false,
//        "zhun": true,
//        "start_send": 20,
//        "send_cost": 4,
//        "distance": 500,
//        "estimate_time": 10,
//        "notice": "新店开张，优惠大酬宾！",
//        "discount": "新用户有巨额优惠！"
//      }
//    ]
//JSON;
    }

    public function goods(Request $request)
    {
        $id = $request->id;
//        dd($id);
        $business = DB::table('information')->find($id);
        $food_categories = DB::table('food_categories')->where('shop_id',$id)->first();
        $food = DB::table('foods')->where('shop_id',$id)->first();
        $business->evaluate = [
            [
                "user_id"=>12344,
                "username"=> "w******k",
                "user_img"=> "http://www.homework.com/images/slider-pic4.jpeg",
                "time"=> "2017-2-22",
                "evaluate_code"=> 1,
                "send_time"=> 30,
                "evaluate_details"=> "不怎么好吃"
            ],
            [
                "user_id"=> 12344,
                "username"=> "w******k",
                "user_img"=> "http://www.homework.com/images/slider-pic4.jpeg",
                "time"=> "2017-2-22",
                "evaluate_code"=> 5,
                "send_time"=> 30,
                "evaluate_details"=> "很好吃"
                ]
        ];
        $business->commodity=[
            [
                "description"=>$food_categories->description,
                "is_selected"=>$food_categories->is_selected,
                "name"=> $food_categories->name,
                "type_accumulation"=>$food_categories->type_accumulation,
                "goods_list"=> [
                    [
                "goods_id"=> 100001,
                "goods_name"=> "$food->food_name",
                "rating"=> $food->rating,
                "goods_price"=>$food->food_price,
                "description"=> $food->description,
                "month_sales"=> 590,
                "rating_count"=> 91,
                "tips"=> $food->tips,
                "satisfy_count"=> 8,
                "satisfy_rate"=> 95,
                "goods_img"=> $food->goods_img
            ],
                    [

                    ],
                ]
            ],
            ];
        return json_encode($business);

    }
}
