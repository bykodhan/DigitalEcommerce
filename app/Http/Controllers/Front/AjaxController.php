<?php

namespace App\Http\Controllers\Front;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Category;
use App\Models\Product;
class AjaxController extends Controller
{
    //

    public function categories($id)
    {
        $category = Category::where('id',$id)->first();
        if($category){
            $products = [];
            foreach($category->products as $item){
                $product=[
                    'id'=>$item->id,
                    'title'=>$item->title,
                ];
                array_push($products,$product);
            }

            return response()->json(['status'=>'success','products'=>$products]);
        }
    }

    public function products()
    {
        $products = Product::all();
        if($products){
            return response()->json(['status'=>'success','products'=>$products]);
        }
    }
}
