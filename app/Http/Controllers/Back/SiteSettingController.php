<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Cache;
use File;
use Image;
use DB;
class SiteSettingController extends Controller
{
    public function index()
    {
        return view('back.settings.site_settings');
    }
    public function footer_links(){
        $footer_links = DB::table('footer_links')->get();
        return view('back.settings.footer_links',compact('footer_links'));
    }
    public function footer_links_store(Request $request){
        $this->validate($request, [
            'title' => 'required',
            'url' => 'required',
        ]);
        $footer_links = DB::table('footer_links')->insert([
            'title' => $request->title,
            'url' => $request->url,
            'target' => $request->target,
        ]);
        return redirect()->back()->with('success','Link eklendi');
    }
    public function footer_links_delete(Request $request){
        $footer_links = DB::table('footer_links')->where('id',$request->id)->delete();
        return redirect()->back()->with('success','Link silindi');
    }

    public function faqs(){
        $faqs = DB::table('faqs')->get();
        return view('back.settings.faqs',compact('faqs'));
    }
    public function faqs_store(Request $request){
        $this->validate($request, [
            'title' => 'required',
            'content' => 'required',
        ]);
        $faqs = DB::table('faqs')->insert([
            'title' => $request->title,
            'content' => $request->content,
        ]);
        return redirect()->back()->with('success','Soru ve cevap eklendi');
    }
    public function faqs_delete(Request $request){
        $faq = DB::table('faqs')->where('id',$request->id)->delete();
        return redirect()->back()->with('success','Soru silindi');
    }

    public function update(Request $request)
    {
        if($request->setting_name == 'contact'){
            Cache::forever('contact_address', $request->contact_address);
            Cache::forever('contact_phone', $request->contact_phone);
            Cache::forever('contact_email', $request->contact_email);
            Cache::forever('contact_mail_from_adress', $request->contact_mail_from_adress);
        }
        if ($request->setting_name == 'extra_code') {
            Cache::forever('extra_header', $request->extra_header);
            Cache::forever('extra_javascript', $request->extra_javascript);
            return redirect()->back()->with('success','Extra Kodlar Güncellendi');
        }
        if ($request->setting_name == 'basic') {
            Cache::forever('site_name', $request->site_name);
            Cache::forever('site_index_title', $request->site_index_title);
            Cache::forever('site_index_description', $request->site_index_description);
            Cache::forever('site_keywords', $request->site_keywords);

            return redirect()->back()->with('success', 'SEO Meta Bilgiler güncellendi.');
        }
        if ($request->setting_name == 'index_info') {
            Cache::forever('index_slogan', $request->index_slogan);
            Cache::forever('index_slogan_description', $request->index_slogan_description);
            return redirect()->back()->with('success', 'Anasayfa Bilgiler güncellendi.');
        }
        if ($request->setting_name == 'smtp_mail') {
            Cache::forever('mail_from_adress', $request->mail_from_adress);
            Cache::forever('mail_from_name', $request->mail_from_name);
            Cache::forever('mail_host', $request->mail_host);
            Cache::forever('mail_port', $request->mail_port);
            Cache::forever('mail_username', $request->mail_username);
            Cache::forever('mail_password', $request->mail_password);
            Cache::forever('mail_secure', $request->mail_secure);
            return redirect()->back()->with('success', 'SMTP Mail Ayarları güncellendi.');
        }
        if ($request->setting_name == 'social_media') {
            Cache::forever('wp', $request->wp);
            Cache::forever('fb', $request->fb);
            Cache::forever('skype', $request->skype);
            Cache::forever('yt', $request->yt);
            Cache::forever('ig', $request->ig);
            Cache::forever('tw', $request->tw);
            Cache::forever('pin', $request->pin);
            Cache::forever('in', $request->in);
            Cache::forever('git', $request->git);
            Cache::forever('tg', $request->tg);
            return redirect()->back()->with('success', 'Sosyal Medya Ayarları güncellendi.');
        }
        if ($request->setting_name == 'logo_favicon') {
            if ($request->logo_img) {
                File::delete(Cache::get('logo_img'));
                $img = $request->logo_img;
                $path = 'uploads/site/logo_' . uniqid() . '.webp';
                Image::make($img)->encode('webp')->save($path);
                Cache::forever('logo_img', $path);
            }
            if ($request->favicon_img) {
                File::delete(Cache::get('favicon_img'));
                $img = $request->favicon_img;
                $path = 'uploads/site/favicon_' . uniqid() . '.webp';
                Image::make($img)->encode('webp')->save($path);
                Cache::forever('favicon_img', $path);
            }
            return redirect()->back()->with('success', 'Logo ve Favicon Ayarları güncellendi.');
        }
        if ($request->setting_name = 'index_images') {
            if ($request->slogan_img) {
                File::delete(Cache::get('slogan_img'));
                $img = $request->slogan_img;
                $path = 'uploads/site/slogan_img' . uniqid() . '.webp';
                Image::make($img)->encode('webp')->save($path);
                Cache::forever('slogan_img', $path);
            }
            if ($request->faq_img) {
                File::delete(Cache::get('faq_img'));
                $img = $request->faq_img;
                $path = 'uploads/site/faq_img' . uniqid() . '.webp';
                Image::make($img)->encode('webp')->save($path);
                Cache::forever('faq_img', $path);
            }
            return redirect()->back()->with('success', 'Anasayfa Görselleri güncellendi.');
        }
    }
}
