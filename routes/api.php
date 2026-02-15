<?php

use App\Http\Controllers\Api\ProductController;

Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{id}', [ProductController::class, 'show']);
Route::get('/filters', [ProductController::class, 'filters']);
Route::get('/products/new', fn() => response()->json([]));
Route::get('/products/top', fn() => response()->json([]));
Route::get('/products/trending', fn() => response()->json([]));

use App\Http\Controllers\CartController;
use App\Http\Controllers\WishlistController;

// Cart API used by frontend scripts
Route::get('/cart', [CartController::class, 'index']);
Route::post('/cart', [CartController::class, 'add']);
Route::delete('/cart/{productId}', [CartController::class, 'remove']);

// Wishlist API
Route::get('/wishlist', [WishlistController::class, 'index']);
Route::post('/wishlist', [WishlistController::class, 'add']);
Route::delete('/wishlist/{productId}', [WishlistController::class, 'remove']);
