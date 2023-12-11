<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PatientController;
use App\Http\Controllers\DiagnosticController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: X-Requested-With, Content-Type, X-Token-Auth, Authorization');

// Route::middleware(['cors'])->group(function () {
Route::group(['middleware' => 'cors'], function () {
    Route::get('/patients', [PatientController::class, 'index'])->name('api.patients.index');
    Route::get('/patients/{id}', [PatientController::class, 'show'])->name('api.patients.show');
    Route::post('/patients', [PatientController::class, 'store'])->name('api.patients.store');
    Route::put('/patients/{id}', [PatientController::class, 'update'])->name('api.patients.update');
    Route::delete('/patients/{id}', [PatientController::class, 'destroy'])->name('api.patients.destroy');
    Route::post('/patients/{patientId}/diagnostics/{diagnosticId}', [PatientController::class, 'assignDiagnostic'])->name('api.patients.assignDiagnostic');
    Route::post('/patients/search', [PatientController::class, 'search'])->name('api.patients.search');
    Route::get('/patients/diagnostics/top', [PatientController::class, 'getTopDiagnosticsLastSixMonths'])->name('api.patients.getTopDiagnosticsLastSixMonths');


    Route::get('/diagnostics', [DiagnosticController::class, 'index'])->name('api.diagnostics.index');
    Route::get('/diagnostics/{id}', [DiagnosticController::class, 'show'])->name('api.diagnostics.show');
    Route::post('/diagnostics', [DiagnosticController::class, 'store'])->name('api.diagnostics.store');
    Route::put('/diagnostics/{id}', [DiagnosticController::class, 'update'])->name('api.diagnostics.update');
    Route::delete('/diagnostics/{id}', [DiagnosticController::class, 'destroy'])->name('api.diagnostics.destroy');
});
