<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Page;
use DB,Cache;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function detail($slug)
    {
        if ($slug == 'sss') {
            $faqs = DB::table('faqs')->get();
            return view('front.faq', compact('faqs'));
        }
        if ($slug == 'iletisim') {
            $faqs = DB::table('faqs')->get();
            return view('front.contact', compact('faqs'));
        }
        $page = Page::where('slug', $slug)->first();
        if ($page) {
            return view('front.page_detail', compact('page'));
        } else {
            abort(404);
        }
    }
    public function contact_post(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email',
            'subject' => 'required',
            'message' => 'required|min:10',
        ]);
        
        $mail = send_mail(Cache::get('contact_mail_from_adress'), $request->subject, $request->message);
        if($mail){
            return redirect()->back()->with('success','Mesajınız başarıyla gönderildi');
        }else{
            dd ($mail);
        }
    }
}
