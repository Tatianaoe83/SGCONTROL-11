<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/debug-auth', function () {
    return auth()->check() ? auth()->user()->email : 'No autenticado';
});

Route::get('/procedimiento/{record}/view-reporte', function ($record) {
    return app()->make(\App\Filament\Resources\ProcedimientoResource\Pages\ViewReporte::class)->mount($record);
})->name('procedimiento.view-reporte');
