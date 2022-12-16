<?php

use App\Http\Controllers\Api\Client\ArticleCategoryController;
use App\Http\Controllers\Api\Client\ArticleController;
use App\Http\Controllers\Api\Client\EmployeeController;
use App\Http\Controllers\Api\Client\PageHeaderController;
use App\Http\Controllers\Api\Client\PartitionController;
use App\Http\Controllers\Api\Client\SliderController;
use App\Http\Controllers\Api\Client\StaticContentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\HttpController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('download-test', [HomeController::class, 'downloadTest']);
Route::post('/upload-test', [HomeController::class, 'uploadTest']);
Route::get('/dispatch-job', [HomeController::class, 'dispatchJob']);
Route::get('/dispatch-mail', [HomeController::class, 'dispatchMail']);
Route::get('/dispatch-event', [HomeController::class, 'dispatchEvent']);
Route::get('/inovice-excel', [HomeController::class, 'invoiceExcel']);
Route::post('/mock-service', [HomeController::class, 'mockService']);

Route::get('/static-content', [StaticContentController::class, 'index']);
Route::get('/articleCategories', [ArticleCategoryController::class, 'index']);
Route::resource('articles', ArticleController::class)->only('index', 'show');
Route::get('/employees', [EmployeeController::class, 'index']);
Route::get('/sliders', [SliderController::class, 'index']);
Route::get('/partitions', [PartitionController::class, 'index']);
Route::get('/pageHeaders', [PageHeaderController::class, 'index']);

Route::post('/test-http-2', [HttpController::class, 'testHttp2']);
Route::get('/test-http-4', [HttpController::class, 'testHttp4']);