<?php

use App\Http\Controllers\Api\CustomerController;
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

Route::group(['prefix' => 'customers'], function(){
    Route::get('/',[CustomerController::class,'index']);
    Route::post('/',[CustomerController::class,'store']);
    Route::get('/{customer}',[CustomerController::class,'view']);
    Route::put('/{customer}',[CustomerController::class,'update']);
    Route::delete('/{customer}',[CustomerController::class,'delete']);
});
