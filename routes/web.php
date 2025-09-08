<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InicioController;

Route::get('/storage/covers/{filename}', function ($filename) {
    $path = storage_path('app/public/covers/' . $filename);
    if (!file_exists($path)) {
        abort(404);
    }
    return Response::file($path);
})->where('filename', '.*');

Route::get('/inicio', [InicioController::class, 'index'])->name('inicio');

Route::get('/inicio/create', [InicioController::class, 'create'])->name('inicio.create');
Route::post('/inicio', [InicioController::class, 'store'])->name('inicio.store');

Route::get('/inicio/{jogo}', [InicioController::class, 'show'])->name('inicio.show');

Route::get('/inicio/{jogo}/edit', [InicioController::class, 'edit'])->name('inicio.edit');
Route::put('/inicio/{jogo}', [InicioController::class, 'update'])->name('inicio.update');

Route::delete('/inicio/{jogo}', [InicioController::class, 'destroy'])->name('inicio.destroy');
