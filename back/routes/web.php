<?php

use App\Http\Controllers\Admin\ImportController;
use App\Http\Controllers\Admin\licensecontroller;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\PanelController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\CroppieController;
use App\Http\Controllers\Front\IndexController;
use App\Http\Controllers\Front\SitemapController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use Modules\PageBuilder\Entities\TemplateRow;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/




// Views Clear:
Route::get('/views-clear', function() {
    Artisan::call('view:clear');
    return '<h1>Views Cleared!</h1>';
});

// Routes Clear:
Route::get('/routes-clear', function() {
    Artisan::call('route:clear');
    return '<h1>Routes Cleared!</h1>';
});

//Clear configurations:
Route::get('/config-clear', function() {
    Artisan::call('config:clear');
    return '<h1>Configurations cleared</h1>';
});

//Clear cache:
Route::get('/cache-clear', function() {
    Artisan::call('cache:clear');
    return '<h1>Cache cleared</h1>';
});

//optimize:
Route::get('/optimize-me', function() {
    Artisan::call('optimize:clear');
    return '<h1>optimized!</h1>';
});

//migrate:
Route::get('/migrate-me', function() {

    // migrate database
    Artisan::call('migrate');

    // create new permissions
    \Spatie\Permission\Models\Permission::firstOrCreate(['name' => 'edit-setting-seo'],['label' => 'ویرایش تنظیمات سئو','guard_name' => 'admin','module' => 'Settings']);
    \Spatie\Permission\Models\Permission::firstOrCreate(['name' => 'edit-setting-advanced'],['label' => 'ویرایش تنظیمات پیشرفته','guard_name' => 'admin','module' => 'Settings']);
    \Spatie\Permission\Models\Permission::firstOrCreate(['name' => 'manage-redirects'],['label' => 'مدیریت ریدایرکت ها','guard_name' => 'admin','module' => 'Redirects']);
    \Spatie\Permission\Models\Permission::firstOrCreate(['name' => 'import-data'],['label' => 'درون ریزی دیتا','guard_name' => 'admin','module' => 'Imports']);
    \Spatie\Permission\Models\Permission::firstOrCreate(['name' => 'manage-product-colors'],['label' => 'مدیریت رنگ های محصولات','guard_name' => 'admin','module' => 'Products']);
    \Spatie\Permission\Models\Permission::firstOrCreate(['name' => 'manage-product-sizes'],['label' => 'مدیریت سایزها محصولات','guard_name' => 'admin','module' => 'Products']);
    \Spatie\Permission\Models\Permission::firstOrCreate(['name' => 'manage-tickets'],['label' => 'مدیریت تیکت ها','guard_name' => 'admin','module' => 'Tickets']);
    \Spatie\Permission\Models\Permission::firstOrCreate(['name' => 'manage-stories'],['label' => 'مدیریت داستان ها','guard_name' => 'admin','module' => 'Story']);
    \Spatie\Permission\Models\Permission::firstOrCreate(['name' => 'manage-templates'],['label' => 'مدیریت قالب ها','guard_name' => 'admin','module' => 'PageBuilder']);
    // import product colors
    $productColorsTableCount = \Modules\Products\Entities\ProductColor::all()->count();
    if ($productColorsTableCount < 1){
        foreach (product_color_list() as $color){
            \Modules\Products\Entities\ProductColor::create([
                'label' => $color['name'],
                'name' => $color['code'],
                'hex_code' => $color['hex_code']
            ]);
        }
    }

    // empty users cart
    \Illuminate\Support\Facades\DB::table('cart_storage')->update(['cart_data' => '']);

    // change model types
    \Illuminate\Support\Facades\DB::table('model_has_roles')
        ->where('model_type','App\Models\Admin')->update(['model_type' => 'Modules\Admins\Entities\Admin']);


    // create home page default template
    $template = \Modules\PageBuilder\Entities\Template::first();
    if (!$template) {
        $template = \Modules\PageBuilder\Entities\Template::create(['title' => 'صفحه اصلی','type' => 'page']);
        $appearanceSettings = \Modules\Settings\Entities\AppearanceSetting::firstOrCreate();
        $appearanceSettings->update(['home_template' => $template->id]);
        TemplateRow::create([
            'template_id' => $template->id,
            'widget_type' => 'stories',
            'widget_name' => 'کاروسل داستان‌ها',
            'widget_icon' => 'bx bx-play-circle',
            'order' => '1',
            'layout' => 'box',
        ]);
        TemplateRow::create([
            'template_id' => $template->id,
            'widget_type' => 'products_carousel',
            'widget_name' => 'کاروسل محصولات',
            'widget_icon' => 'bx bxs-carousel',
            'order' => '2',
            'layout' => 'box',
            'featured_products_title' => 'آخرین محصولات',
            'featured_products_title_icon' => 'icon-percent',
            'featured_products_count' => '12',
            'featured_products_btn_link' => '/products',
            'featured_products_source' => 'newest',
        ]);
        TemplateRow::create([
            'template_id' => $template->id,
            'widget_type' => 'editor',
            'widget_name' => 'ویرایشگر متن',
            'widget_icon' => 'bx bx-align-right',
            'order' => '3',
            'layout' => 'box',
            'featured_products_available' => false,
            'editor_content' => '<h3 class="text-danger">این قالب پیشفرض است، از بخش قالب ها آن را ویرایش کنید.</h3>',
        ]);
    }


    // optimize
    Artisan::call('optimize:clear');

    return '<h1>بروزرسانی انجام شد</h1>';
});


// link storage:
Route::get('/storage-link', function() {
    $targetFolder = storage_path("app/public");
    $linkFolder = $_SERVER['DOCUMENT_ROOT'] . '/storage';
    if (!file_exists($linkFolder)){
        symlink($targetFolder, $linkFolder);
        return '<h1>Success!</h1>';
    }
    return '<h1>Already Done!</h1>';
});


/***********************************
 ********** Admin Routes ***********
 **********************************/
Route::prefix('admin')->group(function () {


    // license
    Route::get('/license', [licensecontroller::class, 'showLicenseForm'])->name('license_form');
    Route::post('/do-license', [licensecontroller::class, 'checkLicense'])->name('license');

    // auth routes
    Route::middleware('guest')->group(function (){
        Route::get('login', [LoginController::class, 'showLoginForm'])->name('admin.login');
        Route::post('login', [LoginController::class, 'login'])->name('admin.do_login');

        // reset password
        Route::get('reset-password', [LoginController::class, 'showResetPasswordForm'])->name('admin.password_request');
        Route::post('reset-password', [LoginController::class, 'passwordEmail'])->name('admin.password_email');
        Route::get('reset-password/{token}', [LoginController::class,'resetPassword'])->name('password.reset');
        Route::post('password-update', [LoginController::class, 'passwordUpdate'])->name('admin.password_update');
    });

    Route::middleware('auth:admin')->group(function () {
        Route::get('logout', [LoginController::class, 'logout'])->name('admin.logout');
        Route::post('get-user-info', [PanelController::class, 'getUserInfo']);

        // front-end icons
        Route::get('icons', [PanelController::class, 'icons'])->name('admin.icons');

        // changelog
        Route::get('changelog', [PanelController::class, 'changelog'])->name('admin.changelog');

        // dashboard
        Route::group(['middleware' => ['can:see-dashboard']], function () {
            Route::get('dashboard', [PanelController::class, 'dashboard'])->name('admin.dashboard');
        });

        // profile
        Route::get('profile', [ProfileController::class, 'index'])->name('admin.profile');
        Route::get('profile/security', [ProfileController::class, 'security'])->name('admin.profile.security');
        Route::post('profile/update/{admin}', [ProfileController::class, 'update'])->name('admin.update');
        Route::post('profile/update/password/{admin}', [ProfileController::class, 'resetPassword'])->name('admin.update.password');

        // tools
        Route::group(['middleware' => ['role_or_permission:super-admin|import-data'],'prefix' => 'tools'], function () {
            Route::get('import',[ImportController::class,'importForm'])->name('tools.import');
            Route::post('do-import',[ImportController::class,'import'])->name('import_csv');
        });


    });

});


/***********************************
 ******** Croppie Routes ***********
 **********************************/
Route::post('croppie/user/avatar', [CroppieController::class, 'avatar']);

/***********************************
 ********** Sitemap Routes *********
 **********************************/
Route::get('/sitemap.xml/',[SitemapController::class,'index'])->name('sitemap');
Route::get('sitemap-page.xml',[SitemapController::class,'pages']);
Route::get('sitemap-post.xml',[SitemapController::class,'posts']);
Route::get('sitemap-product.xml',[SitemapController::class,'products']);
Route::get('sitemap-category.xml',[SitemapController::class,'categories']);
Route::get('sitemap-post-category.xml',[SitemapController::class,'postCategories']);
Route::get('sitemap-tag.xml',[SitemapController::class,'tags']);
Route::get('sitemap-post-tag.xml',[SitemapController::class,'postTags']);
Route::get('sitemap-static.xml',[SitemapController::class,'statics']);

/***********************************
 ********** Site Routes ***********
 **********************************/
Route::get('/', [IndexController::class, 'home'])->name('home');
//Route::get('/blog/search',[IndexController::class,'blogSearch'])->name('search_blog');
