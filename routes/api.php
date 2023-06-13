<?php

use App\Http\Controllers\api\AuthinticationController;
use App\Http\Controllers\api\CardController;
use App\Http\Controllers\api\ContactMessagesController;
use App\Http\Controllers\api\OrdersController;
use App\Http\Controllers\api\PagesController;
use App\Http\Controllers\api\ProductsController;
use App\Http\Controllers\api\ReviewController;
use App\Http\Controllers\api\StaticPagesController;
use App\Http\Controllers\api\UserController;
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

