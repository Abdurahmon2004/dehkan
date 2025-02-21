<?php

use App\Http\Controllers\Api\FullApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::get('/siteInfo', [FullApiController::class, 'siteInfo']);
Route::get('/about', [FullApiController::class, 'about']);
Route::get('/slider', [FullApiController::class, 'slider']);
Route::get('/social', [FullApiController::class, 'social']);
Route::get('/gallery', [FullApiController::class, 'gallery']);
Route::get('/videos', [FullApiController::class, 'video']);

Route::get('/services', [FullApiController::class, 'services']);
Route::get('/service/{id}', [FullApiController::class, 'serviceDetail']);

Route::post('/contact', [FullApiController::class, 'contact']);
