<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Article;
use File,Image;
class BlogController extends Controller
{
    public function index()
    {
        $articles = Article::orderBy('created_at', 'desc')->simplepaginate(100);
        return view('back.blog.index', compact('articles'));
    }
    public function create()
    {
        return view('back.blog.create');
    }
    public function edit($id)
    {
        $article = Article::where('id',$id)->first();
        if($article){
            return view('back.blog.edit', compact('article'));
        }else{
            return redirect()->back()->with('error', 'Yazı bulunamadı');
        }
        return view('back.blog.create');
    }
    public function store(Request $request)
    {
        $article = new Article;
        $article->title = $request->title;
        $article->slug = $request->slug;
        $article->description = $request->description;
        $article->content = $request->content;
        if ($request->img) {
            $path = 'uploads/articles/p_' . uniqid() . '.webp';
            $img = Image::make($request->img)->encode('webp')->save($path);
            $img->destroy();
            $article->img = $path;
        }
        $article->save();
        return redirect()->route('admin.blog')->with('success', 'Yazı oluşturuldu');
    }
    public function update(Request $request)
    {
        $article = Article::where('id', $request->id)->first();
        $article->title = $request->title;
        $article->slug = $request->slug;
        $article->description = $request->description;
        $article->content = $request->content;
        if ($request->img) {
            File::delete($article->img);
            $path = 'uploads/articles/p_' . uniqid() . '.webp';
            $img = Image::make($request->img)->encode('webp')->save($path);
            $img->destroy();
            $article->img = $path;
        }
        $article->save();
        return redirect()->route('admin.blog')->with('success', 'Yazı Güncellendi');
    }

    public function delete(Request $request)
    {
        $article = Article::where('id', $request->id)->first();
        if ($article) {
            File::delete($article->img);
            $article->delete();
            return redirect()->route('admin.blog')->with('success', 'Yazı silindi');
        } else {
            return redirect()->route('admin.blog')->with('error', 'Yazı bulunamadı');
        }
    }
}
