<?php

use Illuminate\Support\Facades\Route;

Auth::routes(['register' => false]);

Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin.role'])->group(function () {
    Route::get('/', [App\Http\Controllers\Back\IndexController::class, 'index'])->name('index');

    Route::get('/categories', [App\Http\Controllers\Back\CategoryController::class, 'index'])->name('categories');
    Route::POST('/categories/store', [App\Http\Controllers\Back\CategoryController::class, 'store'])->name('categories.store');
    Route::POST('/categories/update', [App\Http\Controllers\Back\CategoryController::class, 'update'])->name('categories.update');
    Route::POST('/categories/delete', [App\Http\Controllers\Back\CategoryController::class, 'delete'])->name('categories.delete');

    Route::get('/coupons', [App\Http\Controllers\Back\CouponController::class, 'index'])->name('coupons');
    Route::POST('/coupons/store', [App\Http\Controllers\Back\CouponController::class, 'store'])->name('coupons.store');
    Route::POST('/coupons/update', [App\Http\Controllers\Back\CouponController::class, 'update'])->name('coupons.update');
    Route::POST('/coupons/delete', [App\Http\Controllers\Back\CouponController::class, 'delete'])->name('coupons.delete');

    Route::get('/orders/status/{order_status}', [App\Http\Controllers\Back\OrderController::class, 'index'])->name('orders');
    Route::get('/orders/create', [App\Http\Controllers\Back\OrderController::class, 'create'])->name('orders.create');
    Route::POST('/orders/ok', [App\Http\Controllers\Back\OrderController::class, 'ok'])->name('orders.ok');
    Route::POST('/orders/send_mail', [App\Http\Controllers\Back\OrderController::class, 'order_send_mail'])->name('orders.order_send_mail');
    Route::POST('/orders/delete', [App\Http\Controllers\Back\OrderController::class, 'delete'])->name('orders.delete');
    Route::POST('/orders/cancel', [App\Http\Controllers\Back\OrderController::class, 'cancel'])->name('orders.cancel');
    Route::POST('/orders/edit_stock', [App\Http\Controllers\Back\OrderController::class, 'edit_stock'])->name('orders.edit.stock');

    Route::get('/products', [App\Http\Controllers\Back\ProductController::class, 'index'])->name('products');
    Route::get('/products/create', [App\Http\Controllers\Back\ProductController::class, 'create'])->name('products.create');
    Route::get('/products/edit/{id}', [App\Http\Controllers\Back\ProductController::class, 'edit'])->name('products.edit');

    Route::POST('/products/image/upload', [App\Http\Controllers\Back\ProductController::class, 'image_upload'])->name('products.image.upload');

    Route::POST('/products/store', [App\Http\Controllers\Back\ProductController::class, 'store'])->name('products.store');
    Route::POST('/products/update', [App\Http\Controllers\Back\ProductController::class, 'update'])->name('products.update');
    Route::POST('/products/delete', [App\Http\Controllers\Back\ProductController::class, 'delete'])->name('products.delete');

    Route::get('/pages', [App\Http\Controllers\Back\PageController::class, 'index'])->name('pages');
    Route::get('/pages/create', [App\Http\Controllers\Back\PageController::class, 'create'])->name('pages.create');
    Route::get('/pages/edit/{id}', [App\Http\Controllers\Back\PageController::class, 'edit'])->name('pages.edit');

    Route::POST('/pages/store', [App\Http\Controllers\Back\PageController::class, 'store'])->name('pages.store');
    Route::POST('/pages/update', [App\Http\Controllers\Back\PageController::class, 'update'])->name('pages.update');
    Route::POST('/pages/delete', [App\Http\Controllers\Back\PageController::class, 'delete'])->name('pages.delete');

    Route::get('/blog', [App\Http\Controllers\Back\BlogController::class, 'index'])->name('blog');
    Route::get('/blog/create', [App\Http\Controllers\Back\BlogController::class, 'create'])->name('blog.create');
    Route::get('/blog/edit/{id}', [App\Http\Controllers\Back\BlogController::class, 'edit'])->name('blog.edit');

    Route::POST('/blog/store', [App\Http\Controllers\Back\BlogController::class, 'store'])->name('blog.store');
    Route::POST('/blog/update', [App\Http\Controllers\Back\BlogController::class, 'update'])->name('blog.update');
    Route::POST('/blog/delete', [App\Http\Controllers\Back\BlogController::class, 'delete'])->name('blog.delete');

    Route::get('/modules', [App\Http\Controllers\Back\ModuleController::class, 'index'])->name('modules');
    Route::POST('/modules/update', [App\Http\Controllers\Back\ModuleController::class, 'update'])->name('modules.update');

    Route::get('/site-settings', [App\Http\Controllers\Back\SiteSettingController::class, 'index'])->name('site.settings');
    Route::POST('/site-settings/update', [App\Http\Controllers\Back\SiteSettingController::class, 'update'])->name('site.settings.update');

    Route::get('/footer-links', [App\Http\Controllers\Back\SiteSettingController::class, 'footer_links'])->name('site.settings.footer_links');
    Route::POST('/footer-links/store', [App\Http\Controllers\Back\SiteSettingController::class, 'footer_links_store'])->name('site.settings.footer_links.store');
    Route::POST('/footer-links/delete', [App\Http\Controllers\Back\SiteSettingController::class, 'footer_links_delete'])->name('site.settings.footer_links.delete');

    Route::get('/faqs', [App\Http\Controllers\Back\SiteSettingController::class, 'faqs'])->name('site.settings.faqs');
    Route::POST('/faqs/store', [App\Http\Controllers\Back\SiteSettingController::class, 'faqs_store'])->name('site.settings.faqs.store');
    Route::POST('/faqs/delete', [App\Http\Controllers\Back\SiteSettingController::class, 'faqs_delete'])->name('site.settings.faqs.delete');

    Route::get('/profile', [App\Http\Controllers\Back\ProfileController::class, 'index'])->name('profile');
    Route::POST('/profile/update-info', [App\Http\Controllers\Back\ProfileController::class, 'update_info'])->name('profile.update.info');
    Route::POST('/profile/update-password', [App\Http\Controllers\Back\ProfileController::class, 'update_password'])->name('profile.update.password');

});


Route::controller(App\Http\Controllers\Front\ProductController::class)->group(function () {
    Route::get('/ara', 'search')->name('product.search');
    Route::get('/kategori/{slug}/{sort?}', 'category')->name('category');
    Route::get('/urun/{id}/{slug?}', 'detail')->name('product.detail');
    Route::get('urunler/{sort?}', 'products')->name('products');
});

Route::controller(App\Http\Controllers\Front\AjaxController::class)->group(function () {
    Route::get('/ajax/categories/{id}', 'categories');
    Route::get('/ajax/products', 'products');
});

Route::controller(App\Http\Controllers\Front\OrderController::class)->group(function () {
    Route::get('/siparis/adim-1', 'step_1')->name('order.step_1');
    Route::POST('/siparis/adim-2', 'step_2')->name('order.step_2')->middleware('throttle:order');
    Route::get('/siparis/adim-3', 'step_3')->name('order.step_3');
    Route::POST('/siparis/sorgula', 'check')->name('order.check')->middleware('throttle:order');
    Route::get('/siparis/ok', 'ok')->name('order.ok');
    Route::POST('/siparis/order_send_txt', 'order_send_txt')->name('order.send.txt')->middleware('throttle:order');
    Route::POST('/siparis/coupon/check', 'coupon_check')->name('coupon.check')->middleware('throttle:coupon_check');

    Route::get('/orders/auto/delete', 'auto_delete')->name('orders.auto_delete');
});


Route::controller(App\Http\Controllers\Back\PaymentController::class)->group(function () {
    Route::POST('/paymax/callback', 'paymax_callback')->name('paymax.callback');
    Route::get('/paymax/callback/ok', 'paymaxCallbackOkUrl')->name('paymaxCallbackOkUrl');
    Route::get('/paymax/callback/fail', 'paymaxCallbackFailUrl')->name('paymaxCallbackFailUrl');

    Route::POST('/paytr/callback', 'paytr_callback')->name('paytr.callback');

    Route::get('/paytr/callback/ok', 'paytrCallbackOkUrl')->name('paytrCallbackOkUrl');
    Route::get('/paytr/callback/fail', 'paytrCallbackFailUrl')->name('paytrCallbackFailUrl');

});
Route::POST('/siparis/odeme', [App\Http\Controllers\Front\PaymentController::class, 'payment'])->name('order.payment');

Route::controller(App\Http\Controllers\Front\PageController::class)->group(function () {
    Route::get('/sayfa/{slug?}', 'detail')->name('page.detail');
    Route::POST('/contact/post', 'contact_post')->name('contact.post')->middleware('throttle:order');

});

Route::controller(App\Http\Controllers\Front\ArticleController::class)->group(function () {
    Route::get('/blog', 'index')->name('blog');
    Route::get('/blog/{id}/{slug?}', 'detail')->name('article.detail');
});
Route::get('/sitemap.xml', [App\Http\Controllers\Front\IndexController::class, 'sitemap'])->name('sitemap');
Route::get('/', [App\Http\Controllers\Front\IndexController::class, 'index'])->name('index');
