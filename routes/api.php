<?php


use App\Http\Controllers\api\home\HomeController;
use App\Http\Controllers\api\stores\CategoryController;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'home'], function(){
    Route::get('/', [HomeController::class, 'index']);
});

Route::group(['prefix' => 'stores'], function(){
    Route::get('/{category}', [CategoryController::class, 'index']);
    Route::get('/details/{category}', [CategoryController::class, 'show']);
});

