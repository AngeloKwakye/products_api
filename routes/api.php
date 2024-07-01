<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductController;


Route::get('products',[ProductController::class, 'index']);
Route::post('create-product',[ProductController::class, 'create']);
Route::put('update-product',[ProductController::class, 'update']);
Route::delete('delete-product',[ProductController::class, 'delete']);
Route::post('search',[ProductController::class, 'search']);
/* Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum'); */
