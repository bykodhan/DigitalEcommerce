<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductDetail;
use App\Models\ProductOption;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function search(Request $request)
    {
        $search = $request->search;
        if ($request->search) {
            $result = Product::select('id', 'title', 'slug')->where('title', 'like', '%' . $search . '%')->get();
            return response()->json($result);
        } else {
            return redirect()->back();
        }
    }
    public function products($sort = null)
    {
        switch ($sort) {
            case 'en-son-eklenenler':
                $products = Product::orderBy('created_at', 'desc')->simplePaginate(30);
                $title = 'En Son Eklenenler';
                break;
            case 'dusukten-yuksege':
                $products = Product::orderBy('price', 'asc')->simplePaginate(30);
                $title = 'Önce en düşük fiyat';
                break;
            case 'yuksekten-dusuge':
                $products = Product::orderBy('price', 'desc')->simplePaginate(30);
                $title = 'Önce en yüksek fiyat';
                break;
            case 'indirim-orani':
                $products = Product::orderBy('discount', 'desc')->simplePaginate(30);
                $title = 'İndirim oranına göre';
                break;
            default:
                $products = Product::orderBy('created_at', 'desc')->simplePaginate(30);
                $title = 'En Son Eklenenler';
                break;
        }
        return view('front.products', compact('products', 'title'));
    }
    public function category($slug = null, $sort = null)
    {
        if ($slug) {
            $category = Category::where('slug', $slug)->first();
            if ($category) {
                switch ($sort) {
                    case 'en-son-eklenenler':
                        $products = Product::where('category_id', $category->id)->orderBy('created_at', 'desc')->simplePaginate(30);
                        $title = 'En Son Eklenenler';
                        break;
                    case 'dusukten-yuksege':
                        $products = Product::where('category_id', $category->id)->orderBy('price', 'asc')->simplePaginate(30);
                        $title = 'Önce en düşük fiyat';
                        break;
                    case 'yuksekten-dusuge':
                        $products = Product::where('category_id', $category->id)->orderBy('price', 'desc')->simplePaginate(30);
                        $title = 'Önce en yüksek fiyat';
                        break;
                    case 'indirim-orani':
                        $products = Product::where('category_id', $category->id)->orderBy('discount', 'desc')->simplePaginate(30);
                        $title = 'İndirim oranına göre';
                        break;
                    default:
                        $products = Product::where('category_id', $category->id)->orderBy('created_at', 'desc')->simplePaginate(30);
                        $title = 'En Son Eklenenler';
                        break;
                }
                return view('front.products', compact('products', 'category', 'title'));
            } else {
                return redirect()->route('products');
            }
        }
    }

    //Ürün Detay
    public function detail($id, $slug = null)
    {

        $product = Product::where('id', $id)->first();
        if ($product) {
            $options = ProductOption::where('product_id', $product->id)->get();
            $product_detail = ProductDetail::where('product_id', $product->id)->first();
            return view('front.product_detail', compact('product', 'options', 'product_detail'));
        } else {
            abort(404);
        }
    }

}
