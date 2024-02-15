<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Cache;
class ModuleController extends Controller
{
    public function index()
    {
        return view('back.settings.modules');
    }
    public function update(Request $request)
    {
        if($request->module_name == 'havale_eft'){
            Cache::forever('havale_eft_active', $request->havale_eft_active);
            Cache::forever('havale_eft_info', $request->havale_eft_info);
            return redirect()->back()->with('success', 'Havale/Eft Ödeme modülü güncellendi.');
        }
        if($request->module_name == 'papara'){
            Cache::forever('papara_active', $request->papara_active);
            Cache::forever('papara_account_number', $request->papara_account_number);
            return redirect()->back()->with('success', 'Papara Ödeme modülü güncellendi.');
        }
        if($request->module_name == 'paytr'){
            Cache::forever('paytr_active', $request->paytr_active);
            Cache::forever('paytr_merchant_id', $request->paytr_merchant_id);
            Cache::forever('paytr_merchant_key', $request->paytr_merchant_key);
            Cache::forever('paytr_merchant_salt', $request->paytr_merchant_salt);
            return redirect()->back()->with('success', 'PayTR Ödeme modülü güncellendi.');
        }
        if($request->module_name == 'paymax'){
            Cache::forever('paymax_active', $request->paymax_active);
            Cache::forever('paymax_api_user', $request->paymax_api_user);
            Cache::forever('paymax_api_key', $request->paymax_api_key);
            Cache::forever('paymax_api_url', $request->paymax_api_url);
            Cache::forever('paymax_api_merchant', $request->paymax_api_merchant);
            Cache::forever('paymax_api_hash', $request->paymax_api_hash);
            return redirect()->back()->with('success', 'Paymax Ödeme modülü güncellendi.');
        }
        if($request->module_name == 'flash_news'){
            Cache::forever('flash_news_active', $request->flash_news_active);
            Cache::forever('flash_news_title1', $request->flash_news_title1);
            Cache::forever('flash_news_title2', $request->flash_news_title2);
            Cache::forever('flash_news_title3', $request->flash_news_title3);
            Cache::forever('flash_news_link1', $request->flash_news_link1);
            Cache::forever('flash_news_link2', $request->flash_news_link2);
            Cache::forever('flash_news_link3', $request->flash_news_link3);
            return redirect()->back()->with('success', 'En Üstte Kayan Yazılar modülü güncellendi.');
        }
        if($request->module_name == 'telegram_bot'){
            Cache::forever('telegram_bot_active', $request->telegram_bot_active);
            Cache::forever('telegram_bot_token', $request->telegram_bot_token);
            Cache::forever('telegram_bot_chat_id', $request->telegram_bot_chat_id);
            return redirect()->back()->with('success', 'Telegram Bot modulü güncellendi.');
        }
    }
}
