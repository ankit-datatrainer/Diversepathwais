<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\EnquiryController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\SitemapController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Super admin panel
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('login', [Admin\AuthController::class, 'showLogin'])->name('login');
    Route::post('login', [Admin\AuthController::class, 'login'])->name('login.attempt');

    Route::middleware('super_admin')->group(function () {
        Route::post('logout', [Admin\AuthController::class, 'logout'])->name('logout');
        Route::get('/', [Admin\DashboardController::class, 'index'])->name('dashboard');
        Route::get('seo', [Admin\SeoDashboardController::class, 'index'])->name('seo');

        Route::get('pages', [Admin\PageSeoController::class, 'index'])->name('pages.index');
        Route::get('pages/{page}/edit', [Admin\PageSeoController::class, 'edit'])->name('pages.edit');
        Route::put('pages/{page}', [Admin\PageSeoController::class, 'update'])->name('pages.update');

        Route::get('posts/slug', [Admin\PostController::class, 'slug'])->name('posts.slug');
        Route::post('posts/upload-image', [Admin\PostController::class, 'uploadImage'])->name('posts.upload');
        Route::resource('posts', Admin\PostController::class)->except('show');

        Route::get('enquiries', [Admin\EnquiryController::class, 'index'])->name('enquiries.index');
        Route::get('enquiries/{enquiry}', [Admin\EnquiryController::class, 'show'])->name('enquiries.show');
        Route::patch('enquiries/{enquiry}/toggle', [Admin\EnquiryController::class, 'toggle'])->name('enquiries.toggle');
        Route::delete('enquiries/{enquiry}', [Admin\EnquiryController::class, 'destroy'])->name('enquiries.destroy');

        Route::get('settings', [Admin\SettingController::class, 'edit'])->name('settings.edit');
        Route::put('settings', [Admin\SettingController::class, 'update'])->name('settings.update');

        Route::get('account', [Admin\AccountController::class, 'edit'])->name('account.edit');
        Route::put('account', [Admin\AccountController::class, 'update'])->name('account.update');
    });
});

/*
|--------------------------------------------------------------------------
| Public website
|--------------------------------------------------------------------------
*/
Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('blog/{slug}', [BlogController::class, 'show'])->where('slug', '[A-Za-z0-9\-_]+')->name('blog.show');
Route::post('enquiry', [EnquiryController::class, 'store'])->middleware('throttle:8,1')->name('enquiry.store');
Route::get('sitemap.xml', [SitemapController::class, 'sitemap'])->name('sitemap');
Route::get('robots.txt', [SitemapController::class, 'robots'])->name('robots');

// Old static-site and WordPress URLs keep working (permanent redirects).
Route::permanentRedirect('home', '/');
Route::permanentRedirect('index', '/');
Route::permanentRedirect('about', '/about-us');
Route::permanentRedirect('contact', '/contact-us');
Route::permanentRedirect('careers', '/careers-at-diverse-pathwais');
Route::permanentRedirect('reviews', '/#testimonials');
Route::permanentRedirect('diverse-pathwais-reviews', '/#testimonials');
Route::get('{page}.html', function (string $page) {
    return redirect($page === 'index' ? '/' : '/'.$page, 301);
})->where('page', '[a-z0-9\-]+');

Route::get('{slug}', [PageController::class, 'show'])->where('slug', '[a-z0-9\-]+')->name('page');
