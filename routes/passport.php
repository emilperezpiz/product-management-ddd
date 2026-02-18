<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Laravel\Passport\Http\Controllers\AccessTokenController;
use Laravel\Passport\Http\Controllers\AuthorizedAccessTokenController;
use Laravel\Passport\Http\Controllers\PersonalAccessTokenController;

// Emite tokens de acceso
Route::post('/oauth/token', [AccessTokenController::class, 'issueToken'])
    ->middleware(['throttle'])
    ->name('passport.token');
// Revoca token
Route::delete('/oauth/token', [AuthorizedAccessTokenController::class, 'destroy'])
    ->middleware('auth:api')
    ->name('passport.token.destroy');
// Personal Access Tokens
Route::get('/oauth/personal-access-tokens', [PersonalAccessTokenController::class, 'forUser'])
    ->middleware('auth:api');
Route::post('/oauth/personal-access-tokens', [PersonalAccessTokenController::class, 'store'])
    ->middleware('auth:api');
Route::delete('/oauth/personal-access-tokens/{token_id}', [PersonalAccessTokenController::class, 'destroy'])
    ->middleware('auth:api');
