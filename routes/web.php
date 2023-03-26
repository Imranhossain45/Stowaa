<?php

use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use Spatie\Permission\Models\Permission;
use App\Http\Controllers\Backend\SizeController;
use App\Http\Controllers\Backend\ColorController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\ShopController;
use App\Http\Controllers\Backend\CouponController;
use App\Http\Controllers\Backend\BackendController;
use App\Http\Controllers\Backend\ProductController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\InventoryController;
use App\Http\Controllers\Backend\OrderController;
use App\Http\Controllers\Frontend\FrontendController;
use App\Http\Controllers\SslCommerzPaymentController;
use App\Http\Controllers\UserAuth\UserAuthController;
use App\Http\Controllers\Backend\RolePermissionController;
use App\Http\Controllers\Backend\ShippingChargeController;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\Backend\UserDashboardController;

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
Route::name('frontend.')->group(function () {

    Route::controller(FrontendController::class)->group(function () {
        Route::get('/', "frontendIndex")->name('home');
        Route::get('/contact', "contact")->name('contact');
        Route::get('/about', "about")->name('about');
        Route::get('/team', "team")->name('team');
        Route::get('/shopgrid', "shopgrid")->name('shopgrid');
        Route::get('/shoplist', "shoplist")->name('shoplist');
        Route::get('/shopdetails', "shopdetails")->name('shopdetails');
    });
        

    Route::controller(ShopController::class)->name('shop.')->group(function () {
        Route::get('/shop', 'index')->name('index');
        Route::get('/shop/{slug}', 'shopDetails')->name('details');
        Route::post('/shop/single/color', 'shopColor')->name('color');
        Route::post('/shop/select-color', 'shopSizeColor')->name('color.size.select');
    });
    Route::controller(CartController::class)->middleware(['auth', 'verified'])->prefix('cart')->name('cart.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/store', 'store')->name('store');
        Route::post('/update', 'update')->name('update');
        Route::delete('/delete/{cart}', 'destroy')->name('delete');

        Route::get('checkout', 'checkoutView')->name('checkout.view');
    });
    Route::post('apply/coupon', [CouponController::class, 'applyCoupon'])->name('apply.coupon');
    Route::post('apply/charge', [ShippingChargeController::class, 'applyCharge'])->name('apply.charge');
});

/* User dashboard */

Route::controller(UserDashboardController::class)->prefix('user/dashboard')->name('user.')->middleware(['auth', 'role:user'])->group(function () {
    Route::get('/','index')->name('dashboard');
    Route::get('/orders','order')->name('order');
    Route::get('/invoice/{id}', 'invoice')->name('invoice');
});




/* Backend Routes */
Route::prefix('dashboard')->name('backend.')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/', [BackendController::class, 'dashboardIndex'])->middleware('verified')->name('home');
    Route::middleware(['role:super-admin|admin'])->group(function () {

        /* user route */
        Route::controller(UserController::class)->prefix('user')->name('user.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/store', 'store')->name('store');
            Route::get('/{user}/show', 'show')->name('show');
            Route::get('/{user}/edit', 'edit')->name('edit');
            Route::post('/{user}/update', 'update')->name('update');
            Route::delete('/{user}/delete', 'destroy')->name('trash');
            Route::get('/restore/{id}', 'restore')->name('restore');
            Route::get('/status/{id}', 'status')->name('status');
            Route::delete('/permanent/delete/{id}', 'permanentDestroy')->name('permanent.destroy');
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
        /* Coupon Route */
        Route::controller(CouponController::class)->prefix('coupon')->name('coupon.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('/', 'store')->name('store');
            Route::get('/{coupon}/edit/', 'edit')->name('edit');
            Route::put('/{coupon}/update/', 'update')->name('update');
            Route::delete('/{coupon}/delete/', 'destroy')->name('destroy');
        });
        /* Shipping Charge Route */
        Route::controller(ShippingChargeController::class)->prefix('shipping/charge')->name('shippingcharge.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('/', 'store')->name('store');
            Route::get('/{shippingcharge}/edit/', 'edit')->name('edit');
            Route::put('/{shippingcharge}/update/', 'update')->name('update');
            Route::delete('/{shippingcharge}/delete/', 'destroy')->name('destroy');
        });
        Route::controller(OrderController::class)->prefix('order')->name('order.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/show/{order}', 'show')->name('show');
            Route::get('/update/{order}', 'update')->name('update');
            Route::get('/status/{order}', 'status')->name('status');
        });
    });
    /* Role and Permission */
    Route::controller(RolePermissionController::class)->prefix('role')->name('role.')->group(function () {
        Route::get('/', 'indexRole')->name('index')->middleware(['role_or_permission:super-admin|see role']);
        Route::get('/create', 'createRole')->name('create')->middleware(['role_or_permission:super-admin|create role']);
        Route::post('/store', 'storeRole')->name('store')->middleware(['role_or_permission:super-admin|create role']);
        Route::get('/edit/{id}', 'editRole')->name('edit')->middleware(['role_or_permission:super-admin|edit role']);
        Route::post('/update/{id}', 'updateRole')->name('update')->middleware(['role_or_permission:super-admin|edit role']);


        Route::post('/permission/store', [RolePermissionController::class, 'permissionStore'])->name('permission.store');
    });
});


/* User Auth */
Route::get('/user/login', [UserAuthController::class, "login"])->name('user.login');
Route::get('/user/registration', [UserAuthController::class, "registration"])->name('user.registration');



// SSLCOMMERZ Start

Route::post('/pay', [SslCommerzPaymentController::class, 'index']);

Route::post('/success', [SslCommerzPaymentController::class, 'success']);
Route::post('/fail', [SslCommerzPaymentController::class, 'fail']);
Route::post('/cancel', [SslCommerzPaymentController::class, 'cancel']);

Route::post('/ipn', [SslCommerzPaymentController::class, 'ipn']);
//SSLCOMMERZ END