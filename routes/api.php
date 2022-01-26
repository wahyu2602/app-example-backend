<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
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

Route::post('register', [AuthController::class, 'Register']);
Route::post('login', [AuthController::class, 'Login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', [AuthController::class, 'Logout']);
});

Route::get('post', [PostController::class, 'index']);
Route::get('post/{post}', [PostController::class, 'show']);

Route::resource('post', PostController::class)->only([
    'store', 'update', 'destroy'
])->middleware('auth:sanctum');
