<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;

Route::get('/',[ProductController::class,'index']);
Route::get('/item/{id}',[ProductController::class,'show']);

Route::get('/mypage/profile',[ProfileController::class,'create'])->middleware('auth');
Route::post('/mypage/profile',[ProfileController::class,'store'])->middleware('auth');
