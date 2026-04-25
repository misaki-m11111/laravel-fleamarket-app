<?php

use App\Http\Controllers\MypageController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PurchaseController;
use GuzzleHttp\Promise\Create;

Route::get('/',[ItemController::class,'index']);
Route::get('/item/{id}',[ItemController::class,'show']);

Route::get('/sell',[ItemController::class,'create'])->middleware('auth');
Route::post('/sell',[ItemController::class,'store'])->middleware('auth');

Route::get('/mypage',[MypageController::class,'index'])->middleware('auth');

Route::get('/mypage/profile',[ProfileController::class,'edit'])->middleware('auth');
Route::post('/mypage/profile',[ProfileController::class,'update'])->middleware('auth');

Route::get('/purchase/{id}',[PurchaseController::class,'create'])->middleware('auth');
Route::post('/purchase/{id}',[PurchaseController::class,'store'])->middleware('auth');
