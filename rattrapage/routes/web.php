<?php

use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ConvocationController;
use App\Http\Controllers\LocaleController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\OpsController;
use Illuminate\Support\Facades\Route;

Route::get('/', [LoginController::class, 'showForm']);

Route::post('/login', [LoginController::class, 'authenticate'])->middleware('throttle.login');

Route::post('/locale/{locale}', [LocaleController::class, 'set']);

Route::get('/verify', [ConvocationController::class, 'verify']);
Route::post('/presence/mark', [ConvocationController::class, 'markPresence']);

Route::prefix('admin')->group(function () {
    Route::get('/recherche', [AdminController::class, 'showRecherche']);
    Route::post('/recherche', [AdminController::class, 'search']);
});

Route::prefix('ops')->group(function () {
    Route::get('/liste-etudiants', [OpsController::class, 'listeEtudiants']);

    Route::get('/export-pdfs', [OpsController::class, 'exportPdfs']);
    Route::get('/presence-pdf', [OpsController::class, 'presencePdf']);
});

Route::middleware('auth.etudiant')->group(function () {
    Route::get('/convocation', [ConvocationController::class, 'show']);

    Route::get('/convocation/pdf', [ConvocationController::class, 'pdf']);

    Route::post('/logout', [LoginController::class, 'logout']);
});

Route::get('/_smoke/pdf', function () {
    abort_unless(app()->environment(['local', 'testing']), 404);

    return Pdf::loadView('pdf.smoke')->stream('smoke.pdf');
});
