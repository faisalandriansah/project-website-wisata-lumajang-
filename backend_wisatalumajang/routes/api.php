<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\WisataController;
use App\Http\Controllers\Api\CommentController;

Route::apiResource('wisata', WisataController::class)->parameters([
    'wisata' => 'wisata'
]);
Route::post('comment', [CommentController::class, 'store']);

