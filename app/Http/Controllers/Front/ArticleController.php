<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Article;
class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::orderByDesc('created_at')->simplepaginate(30);
        return view('front.articles', compact('articles'));
    }
    public function detail($id,$slug=null)
    {
        $article = Article::where('id', $id)->first();
        if ($article) {
            return view('front.article_detail', compact('article'));
        } else {
            abort(404);
        }
    }
}
