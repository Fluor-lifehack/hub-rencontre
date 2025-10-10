<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CountryController;
use App\Http\Controllers\Api\MatchController;
use App\Http\Controllers\Api\PhotoController;
use App\Http\Controllers\Api\PlanController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Routes d'authentification (publiques)
Route::prefix('v1')->group(function () {
    Route::post('/auth/login', [AuthController::class, 'login']);
    Route::post('/auth/register', [AuthController::class, 'register']);

    // Routes publiques
    Route::get('/countries', [CountryController::class, 'index']);
    Route::get('/countries/{id}', [CountryController::class, 'show']);
    Route::get('/plans', [PlanController::class, 'index']);
    Route::get('/plans/{id}', [PlanController::class, 'show']);

    // Routes protégées par authentification
    Route::middleware('auth:sanctum')->group(function () {
        // Authentification
        Route::post('/auth/logout', [AuthController::class, 'logout']);
        Route::get('/auth/me', [AuthController::class, 'me']);

        // Utilisateurs
        Route::apiResource('users', UserController::class);

        // Profils
        Route::apiResource('profiles', ProfileController::class);

        // Correspondances
        Route::apiResource('matches', MatchController::class);

        // Photos
        Route::apiResource('photos', PhotoController::class);

        // Pays (CRUD complet pour les admins)
        Route::post('/countries', [CountryController::class, 'store']);
        Route::put('/countries/{id}', [CountryController::class, 'update']);
        Route::delete('/countries/{id}', [CountryController::class, 'destroy']);

        // Plans (CRUD complet pour les admins)
        Route::post('/plans', [PlanController::class, 'store']);
        Route::put('/plans/{id}', [PlanController::class, 'update']);
        Route::delete('/plans/{id}', [PlanController::class, 'destroy']);

        // Route de test pour Scribe
        Route::get('/user', function (Request $request) {
            return response()->json([
                'success' => true,
                'data' => $request->user(),
            ]);
        });
    });
});
