<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ProductController;

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

//Route::group(['prefix' => 'products'], function(){
//    Route::get('/',[ProductController::class,'index']);
//    Route::post('/',[ProductController::class,'store']);
//    Route::get('/{product}',[ProductController::class,'show']);
//    Route::put('/{product}',[ProductController::class,'update']);
//    Route::delete('/{product}',[ProductController::class,'delete']);
//});


//
//Route::group(['prefix' => 'categories'], function(){
//    Route::get('/',[CategoryController::class,'index']);
//    Route::post('/',[CategoryController::class,'store']);
//    Route::put('/{category}',[CategoryController::class,'update']);
//    Route::delete('/{category}',[CategoryController::class,'delete']);
//});

Route::apiResource('/products',ProductController::class);
Route::apiResource('/categories',CategoryController::class);
