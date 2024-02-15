<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use App\Models\Category;
use App\Models\Product;
use Cache;
use View;
use DB;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap(5);

        config(['app.name' => Cache::get('site_name')]);
        config(['mail.mailers.smtp.host' => Cache::get('mail_host')]);
        config(['mail.mailers.smtp.port' => Cache::get('mail_port')]);
        config(['mail.mailers.smtp.username' => Cache::get('mail_username')]);
        config(['mail.mailers.smtp.password' => Cache::get('mail_password')]);
        config(['mail.mailers.smtp.encryption' => Cache::get('mail_secure')]);

        View::composer(['back.layouts.app'], function ($view) {
            $orders = DB::table('orders')->select('order_status')->get();
            $view->with(compact('orders'));
        });
        View::composer(['front.layouts.topbar'], function ($view) {
            $categories = Category::where('parent_id', null)->orderBy('sortable')->get();
            $products_count = Product::count();
            $view->with(compact('categories', 'products_count'));
        });
        View::composer(['front.layouts.footer'], function ($view) {
            $footer_links = DB::table('footer_links')->get();
            $view->with(compact('footer_links'));
        });
    }
}
