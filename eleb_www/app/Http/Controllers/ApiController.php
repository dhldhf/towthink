<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiController extends Controller
{
    public function show()
    {
        $shops = DB::table('information')->get();

        foreach ($shops as $shop){
            $shop->distance = 637;
        }
        return $shops;
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
}
