<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\SentinelApiController;

/*
|--------------------------------------------------------------------------
| Sentinel Immutability Engine — Internal API Routes
|--------------------------------------------------------------------------
| These routes are internal-only and protected by the ProductionShield.
| The SentinelAuditResource is returned for any holistic-scan record.
|
*/

// Phase 3 — Sentinel Immutability Engine (Resource Read)
Route::prefix('sentinel')->group(function () {
    Route::get('/latest', [SentinelApiController::class, 'latest'])->name('sentinel.latest');
    Route::get('/pulse', [SentinelApiController::class, 'pulse'])->name('sentinel.pulse');
});
