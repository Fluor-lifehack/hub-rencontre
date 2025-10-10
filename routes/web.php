<?php

use App\Http\Controllers\TestController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/admin');
});

// Routes de test pour les WebSockets
Route::get('/websocket-test', function () {
    return file_get_contents(public_path('websocket-test.html'));
});

Route::prefix('test')->group(function () {
    Route::get('/', [TestController::class, 'index']);
    Route::post('/event', [TestController::class, 'sendTestEvent']);
    Route::post('/match', [TestController::class, 'simulateMatch']);
    Route::post('/message', [TestController::class, 'simulateMessage']);
});
