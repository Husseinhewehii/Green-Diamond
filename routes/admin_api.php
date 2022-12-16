<?php

use App\Http\Controllers\Api\Admin\AuthController;
use App\Http\Controllers\Api\Admin\ArticleCategoryController;
use App\Http\Controllers\Api\Admin\ArticleController;
use App\Http\Controllers\Api\Admin\RoleController;
use App\Http\Controllers\Api\Admin\SettingController;
use App\Http\Controllers\Api\Admin\StaticContentController;
use App\Http\Controllers\Api\Admin\UserController;
use App\Http\Controllers\Api\Admin\EmployeeController;
use App\Http\Controllers\Api\Admin\PageHeaderController;
use App\Http\Controllers\Api\Admin\PartitionController;
use App\Http\Controllers\Api\Admin\SliderController;
use App\Http\Controllers\Api\Admin\TagController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/



Route::group([
    'prefix' => LaravelLocalization::setLocale()
    ], function(){

        Route::name('admin.')->group(function(){
            Route::get('/test', function(){
                return "here is a test route";
            });

            Route::controller(AuthController::class)->group(function(){
                Route::post('/login', "login")->name('login');
            });


            Route::middleware('auth:api')->group(function () {
                Route::get('/auth/test', function(){
                    return "here is an auth test route";
                });

                Route::controller(AuthController::class)->group(function(){
                    Route::post('/logout', "logout")->name('logout');
                });

                Route::resource('static-content', StaticContentController::class)->only('index', 'update');
                Route::resource('settings', SettingController::class)->only('index', 'update');

                Route::resource('users', UserController::class);
                Route::resource('roles', RoleController::class);
                Route::resource('employees', EmployeeController::class);
                Route::resource('articleCategories', ArticleCategoryController::class);
                Route::resource('articles', ArticleController::class);
                Route::resource('tags', TagController::class);
                Route::resource('partitions', PartitionController::class)->only('update', 'index', 'show');
                Route::resource('pageHeaders', PageHeaderController::class)->only('update', 'index', 'show');
                Route::resource('sliders', SliderController::class)->only('store', 'index', 'destroy');

            });
        });

});




