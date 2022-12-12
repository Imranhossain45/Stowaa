<?php

use App\Http\Controllers\Backend\BackendController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\RolePermissionController;
use App\Http\Controllers\Frontend\FrontendController;
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
Route::controller(FrontendController::class)->name('frontend.')->group(function(){
    Route::get('/',"frontendIndex")->name('home');
    Route::get('/contact',"contact")->name('contact');
    Route::get('/about',"about")->name('about');
    Route::get('/team',"team")->name('team');
    Route::get('/shopgrid', "shopgrid")->name('shopgrid');
    Route::get('/shoplist', "shoplist")->name('shoplist');
    Route::get('/shopdetails', "shopdetails")->name('shopdetails');

});



/* Backend Routes */
Route::prefix('dashboard')->name('backend.')->group(function () {
    Route::get('/', [BackendController::class, 'dashboardIndex'])->middleware('verified')->name('home');

    /* Role and Permission */
    Route::controller(RolePermissionController::class)->group(function () {
        Route::get('/role', 'indexRole')->name('role.index')->middleware(['role_or_permission:super-admin|see role']);
        Route::get('/role/create','createRole')->name('role.create')->middleware(['role_or_permission:super-admin|create role']);
        Route::post('/role/store','storeRole')->name('role.store')->middleware(['role_or_permission:super-admin|create role']);
        Route::get('/role/edit/{id}','editRole')->name('role.edit')->middleware(['role_or_permission:super-admin|edit role']);
        Route::post('/role/update/{id}','updateRole')->name('role.update')->middleware(['role_or_permission:super-admin|edit role']);


        Route::post('/permission/store', [RolePermissionController::class, 'permissionStore'])->name('permission.store');
    });
    /* Category Route */
    Route::controller(CategoryController::class)->group(function (){
        Route::get('/category','index')->name('category.index');
        Route::post('/category','store')->name('category.store');
        Route::get('/category/create','create')->name('category.create');
        Route::get('/category/{category}/show/','show')->name('category.show');
        Route::get('/category/{category}/edit/','edit')->name('category.edit');
        Route::put('/category/{category}/update/','update')->name('category.update');
        Route::delete('/category/{category}/delete/', 'destroy')->name('category.destroy');
    });
});


/* User Auth */
Route::get('/user/login',[UserAuthController::class,"login"])->name('user.login');
Route::get('/user/registration',[UserAuthController::class, "registration"])->name('user.registration');