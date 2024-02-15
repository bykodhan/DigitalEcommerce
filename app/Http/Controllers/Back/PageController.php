<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index()
    {
        $pages = Page::orderBy('created_at', 'desc')->simplepaginate(100);
        return view('back.pages.index', compact('pages'));
    }
    public function create()
    {
        return view('back.pages.create');
    }
    public function edit($id)
    {
        $page = Page::where('id',$id)->first();
        if($page){
            return view('back.pages.edit', compact('page'));
        }else{
            return redirect()->back()->with('error', 'Sayfa bulunamadı');
        }
    }
    public function store(Request $request)
    {
        $page = new Page;
        $page->title = $request->title;
        $page->slug = $request->slug;
        $page->description = $request->description;
        $page->content = $request->content;
        $page->save();
        return redirect()->route('admin.pages')->with('success', 'Sayfa oluşturuldu');
    }
    public function update(Request $request)
    {
        $page = Page::where('id', $request->id)->first();
        $page->title = $request->title;
        $page->slug = $request->slug;
        $page->description = $request->description;
        $page->content = $request->content;
        $page->save();
        return redirect()->route('admin.pages')->with('success', 'Sayfa Güncellendi');
    }

    public function delete(Request $request)
    {
        $page = Page::where('id', $request->id)->first();
        if ($page) {
            $page->delete();
            return redirect()->route('admin.pages')->with('success', 'Sayfa silindi');
        } else {
            return redirect()->route('admin.pages')->with('error', 'Sayfa bulunamadı');
        }
    }

}
