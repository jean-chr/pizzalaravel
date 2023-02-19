<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Api\PizzaController;

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

Route::Apiresource('pizzas', PizzaController::class);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
    //return Auth::user();
});

Route::middleware('auth:sanctum')
    ->get('/logout', [AuthController::class, 'logout']);

Route::Post('/register', [AuthController::class, 'register']);
Route::Post('/login', [AuthController::class, 'login'])->name('login');

//Route::ApiResource('pizzas', PizzaController::class)->middleware('auth:sanctum');

Route::Get('/pizzas', [PizzaController::class, 'index']);

Route::group([
    'middleware' => 'auth:sanctum',
    // 'prefix' => 'auth'
], function ($router) {
});
