<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\MypageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PurchaseController;

Route::get('/email/verify', function () {
  return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/', [ItemController::class, 'index']);
Route::get('/item/{item_id}', [ItemController::class, 'show']);

Route::middleware('auth')->group(function () {

  Route::get('/mypage/profile', [ProfileController::class, 'edit'])
    ->middleware('verified');

  Route::put('/mypage/profile', [ProfileController::class, 'update'])
    ->middleware('verified');

  Route::get('/sell', [ItemController::class, 'create']);
  Route::post('/sell', [ItemController::class, 'store']);

  Route::post('/like/{item_id}', [LikeController::class, 'store']);
  Route::delete('/like/{item_id}', [LikeController::class, 'destroy']);

  Route::post('/comment/{item_id}', [CommentController::class, 'store']);

  Route::get('/mypage', [MypageController::class, 'index']);

  Route::get('/purchase/{item_id}', [PurchaseController::class, 'create']);
  Route::post('/purchase/{item_id}', [PurchaseController::class, 'store']);

  Route::get('/purchase/success/{item_id}', [PurchaseController::class, 'success']);
  Route::get('/purchase/cancel/{item_id}', [PurchaseController::class, 'cancel']);

  Route::get('/purchase/address/{item_id}', [PurchaseController::class, 'editAddress']);
  Route::put('/purchase/address/{item_id}', [PurchaseController::class, 'updateAddress']);
});
