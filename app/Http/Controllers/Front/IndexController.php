<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use App\Models\Product;
use App\Models\Page;
use DB;

class IndexController extends Controller
{
    public function index()
    {
        $categories = Category::where('parent_id', null)->orderBy('sortable')->get();
        $products = Product::with('category:id,title,slug,img')->orderBy('created_at', 'desc')->where('favorite_index', 1)->get();
        $faqs = DB::table('faqs')->get();
        $articles = Article::orderBy('created_at', 'desc')->take(3)->get();
        return view('front.index', compact('categories', 'products', 'faqs', 'articles'));
    }
    public function sitemap()
    {
        $products = Product::select('id','slug')->get();
        $categories = Category::all();
        $articles = Article::select('id','slug');
        $pages = Page::all();
        $view = view('front.partials.sitemap', compact('products', 'categories', 'articles', 'pages'));
        return response($view)->header('Content-Type', 'application/xml');

    }
}
