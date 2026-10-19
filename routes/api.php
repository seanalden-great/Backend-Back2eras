<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\SubscriberController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\VendorCategoryController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/contact', [ContactController::class, 'store']);
Route::post('/subscribe', [SubscriberController::class, 'store']);

// Rute untuk Publik (User Apply & Cancel)
Route::get('/applications', [ApplicationController::class, 'index']);
Route::post('/applications', [ApplicationController::class, 'store']);
Route::delete('/applications/{id}', [ApplicationController::class, 'destroy']);

// Rute untuk Admin (Accept/Reject)
Route::put('/applications/{id}/accept', [ApplicationController::class, 'accept']);
Route::put('/applications/{id}/reject', [ApplicationController::class, 'reject']);

Route::apiResource('vendor-categories', VendorCategoryController::class);
