<?php

use App\Http\Controllers\Backend\BackendController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\ColorController;
use App\Http\Controllers\Backend\InventoryController;
use App\Http\Controllers\Backend\ProductController;
use App\Http\Controllers\Backend\RolePermissionController;
use App\Http\Controllers\Backend\SizeController;
use App\Http\Controllers\Frontend\FrontendController;
use App\Http\Controllers\Frontend\ShopController;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserAuth\UserAuthController;
use Spatie\Permission\Models\Permission;

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

Auth::routes(['verify' => true]);
/* Frontend Routes */
Route::controller(FrontendController::class)->name('frontend.')->group(function () {
    Route::get('/', "frontendIndex")->name('home');
    Route::get('/contact', "contact")->name('contact');
    Route::get('/about', "about")->name('about');
    Route::get('/team', "team")->name('team');
    Route::get('/shopgrid', "shopgrid")->name('shopgrid');
    Route::get('/shoplist', "shoplist")->name('shoplist');
    Route::get('/shopdetails', "shopdetails")->name('shopdetails');
});

Route::controller(ShopController::class)->name('frontend.shop.')->group(function () {
    Route::get('/shop', 'index')->name('index');
    Route::get('/shop/{slug}', 'shopDetails')->name('details');
    Route::post('/shop/single/color', 'shopColor')->name('color');
    Route::post('/shop/select-color', 'shopSizeColor')->name('color.size.select');
});



/* Backend Routes */
Route::prefix('dashboard')->name('backend.')->group(function () {
    Route::get('/', [BackendController::class, 'dashboardIndex'])->middleware('verified')->name('home');

    /* Role and Permission */
    Route::controller(RolePermissionController::class)->prefix('role')->name('role.')->group(function () {
        Route::get('/', 'indexRole')->name('index')->middleware(['role_or_permission:super-admin|see role']);
        Route::get('/create', 'createRole')->name('create')->middleware(['role_or_permission:super-admin|create role']);
        Route::post('/store', 'storeRole')->name('store')->middleware(['role_or_permission:super-admin|create role']);
        Route::get('/edit/{id}', 'editRole')->name('edit')->middleware(['role_or_permission:super-admin|edit role']);
        Route::post('/update/{id}', 'updateRole')->name('update')->middleware(['role_or_permission:super-admin|edit role']);


        Route::post('/permission/store', [RolePermissionController::class, 'permissionStore'])->name('permission.store');
    });
    /* Product Route */
    Route::controller(ProductController::class)->prefix('product')->name('product.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::get('/{product}/show/', 'show')->name('show');
        Route::get('/{product}/edit/', 'edit')->name('edit');
        Route::put('/{product}/update/', 'update')->name('update');
        Route::delete('/{product}/delete/', 'destroy')->name('destroy');
        Route::get('/restore/{id}', 'restore')->name('restore');
        Route::delete('/permanent/delete/{id}', 'permanentDestroy')->name('permanent.destroy');
    });
    /* Inventory Route */
    Route::controller(InventoryController::class)->prefix('product/inventory')->name('product.inventory.')->group(function () {
        Route::get('/{id}', 'index')->name('index');
        /* Route::get('/create', 'create')->name('create'); */
        Route::post('/', 'store')->name('store');
        Route::get('/{inventory}/show/', 'show')->name('show');
        Route::get('/{inventory}/edit/', 'edit')->name('edit');
        Route::put('/{inventory}/update/', 'update')->name('update');
        Route::delete('/{inventory}/delete/', 'destroy')->name('destroy');
        /* Route::get('/restore/{id}', 'restore')->name('restore');
        Route::delete('/permanent/delete/{id}', 'permanentDestroy')->name('permanent.destroy'); */

        Route::post('/select/color', 'colorSelect')->name('color.select');
    });

    /* Product Category Route */
    Route::controller(CategoryController::class)->prefix('category')->name('category.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'store')->name('store');
        Route::get('/{category}/show/', 'show')->name('show');
        Route::get('/{category}/edit/', 'edit')->name('edit');
        Route::put('/{category}/update/', 'update')->name('update');
        Route::delete('/{category}/delete/', 'destroy')->name('destroy');
    });
    /* Color Route */
    Route::controller(ColorController::class)->prefix('color')->name('color.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'store')->name('store');
        Route::get('/{color}/show/', 'show')->name('show');
        Route::get('/{color}/edit/', 'edit')->name('edit');
        Route::put('/{color}/update/', 'update')->name('update');
        Route::delete('/{color}/delete/', 'destroy')->name('destroy');
    });
    /* Size Route */
    Route::controller(SizeController::class)->prefix('size')->name('size.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'store')->name('store');
        Route::get('/{size}/show/', 'show')->name('show');
        Route::get('/{size}/edit/', 'edit')->name('edit');
        Route::put('/{size}/update/', 'update')->name('update');
        Route::delete('/{size}/delete/', 'destroy')->name('destroy');
    });
});


/* User Auth */
Route::get('/user/login', [UserAuthController::class, "login"])->name('user.login');
Route::get('/user/registration', [UserAuthController::class, "registration"])->name('user.registration');