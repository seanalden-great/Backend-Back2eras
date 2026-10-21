<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\SubscriberController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\PartnerController;
use App\Http\Controllers\StoryController;
use App\Http\Controllers\TenantController;
use App\Http\Controllers\VendorCategoryController;
use App\Http\Controllers\VisitorController;

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

Route::get('/stories', [StoryController::class, 'index']);
Route::get('/stories/{slug}', [StoryController::class, 'show']);
Route::post('/stories', [StoryController::class, 'store']);
Route::put('/stories/{id}', [StoryController::class, 'update']);
Route::delete('/stories/{id}', [StoryController::class, 'destroy']);

Route::get('/contacts', [ContactController::class, 'index']);
Route::post('/contacts', [ContactController::class, 'store']);
Route::delete('/contacts/{id}', [ContactController::class, 'destroy']);
Route::post('/contacts/{id}/reply', [ContactController::class, 'reply']);

// Route untuk Visitor Registration
Route::get('/visitors', [VisitorController::class, 'index']);
Route::post('/visitors', [VisitorController::class, 'store']);
Route::delete('/visitors/{id}', [VisitorController::class, 'destroy']);

// Route untuk Tenant Registration
Route::get('/tenants', [TenantController::class, 'index']);
Route::post('/tenants', [TenantController::class, 'store']);
Route::put('/tenants/{id}/status', [TenantController::class, 'updateStatus']); // Untuk admin merubah status
Route::delete('/tenants/{id}', [TenantController::class, 'destroy']);

// Route untuk Partnership
Route::get('/partners', [PartnerController::class, 'index']);
Route::post('/partners', [PartnerController::class, 'store']);
Route::put('/partners/{id}/status', [PartnerController::class, 'updateStatus']); 
Route::delete('/partners/{id}', [PartnerController::class, 'destroy']);

// Route untuk Media Partnership
Route::get('/media', [MediaController::class, 'index']);
Route::post('/media', [MediaController::class, 'store']);
Route::put('/media/{id}/status', [MediaController::class, 'updateStatus']); 
Route::delete('/media/{id}', [MediaController::class, 'destroy']);
