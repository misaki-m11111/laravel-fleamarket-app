<?php

use App\Http\Controllers\MypageController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;

Route::get('/',[ProductController::class,'index']);
Route::get('/item/{id}',[ProductController::class,'show']);

Route::get('/mypage',[MypageController::class,'index'])->middleware('auth');

Route::get('/mypage/profile',[ProfileController::class,'edit'])->middleware('auth');
Route::post('/mypage/profile',[ProfileController::class,'update'])->middleware('auth');


