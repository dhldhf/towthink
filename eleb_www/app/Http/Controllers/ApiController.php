<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiController extends Controller
{
    public function show(Request $request)
    {
//        dd($request->keyword);
        $cl = new \App\SphinxClient();
        $cl->SetServer ( '127.0.0.1', 9312);
//$cl->SetServer ( '10.6.0.6', 9312);
//$cl->SetServer ( '10.6.0.22', 9312);
//$cl->SetServer ( '10.8.8.2', 9312);
        $cl->SetConnectTimeout ( 10 );
        $cl->SetArrayResult ( true );
// $cl->SetMatchMode ( SPH_MATCH_ANY);
        $cl->SetMatchMode ( SPH_MATCH_EXTENDED2);
        $cl->SetLimits(0, 1000);//返回多少条数据
        $info = $request->keyword;
        $res = $cl->Query($info, 'information');//shopstore_search
//print_r($cl);
//    print_r($res);
        if (empty($res)){
            $shops = DB::table('information')->get();

            foreach ($shops as $shop){
                $shop->distance = 637;
            }
            return $shops;
            }

        if ($res['total']){
            //获取商家id
            $datas =  collect($res['matches'])->pluck('id')->toArray();
//            dd($datas);
            $shops = [];
            foreach ($datas as $da){
               $shop = DB::table('information')->where('id','=',$da)->first();
//                dd($shop);
                $shop->distance = 637;
                $shops[] = $shop;
            };
            return $shops;
        }elseif(!$res['total']){
            return [['shop_name'=>'没有找到'.$request->keyword.'该商品']];
        }


    }

    public function goods(Request $request)
    {
        $id = $request->id;
        $business = DB::table('information')->find($id);
        $categories = DB::table('food_categories')->where('shop_id','=',$id)->get();
        $food = DB::table('foods')->where('shop_id','=',$id)->get();
        $category = [];
        foreach ($categories as $food_categories){
            $food_categories->goods_list = [];
            foreach ($food as $foodes){
                $food_categories->goods_list[] = $foodes;
            }
            $category[] = $food_categories;
        }
        $business->commodity=$category;
        return json_encode($business);

    }

    public function search()
    {
        echo 254768;die;
    }
}
