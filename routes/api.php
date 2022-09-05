<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\imageController;





Route::post('user-signup', [UserController::class, 'userSignup']);
Route::get('upload-image', [imageController::class, 'uploadImage']);
