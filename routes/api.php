<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

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

Route::get('/test', function () {
    return 'test';
    });

Route::post('user-signup', [UserController::class, 'userSignup']);


// Route::post('/user-signup', 'UserController@userSignUp')->name('userSignup.perform');



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
