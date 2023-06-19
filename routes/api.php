<?php


use App\Http\Controllers\api\home\CountryController;
use App\Http\Controllers\api\home\HomeController;
use App\Http\Controllers\api\stores\StoreController;
use App\Http\Controllers\api\users\AuthinticationController;
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
    Route::get('/{store}', [StoreController::class, 'index']);
    Route::get('/details/{store}', [StoreController::class, 'show']);
});

Route::group(['prefix'=> 'countries'], function(){
    Route::get('/', [CountryController::class, 'index']);
});

/**
 *
 * //authintication routes
 *
 */
Route::group(['prefix' => 'users'], function () {
    Route::post('smsOtp', [AuthinticationController::class, 'smsOtp']);
    Route::post('checkOtp', [AuthinticationController::class, 'checkOtp']);
    Route::post('logout', [AuthinticationController::class, 'logout'])->middleware('auth:sanctum');

});
