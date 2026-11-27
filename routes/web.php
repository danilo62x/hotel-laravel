<?php

use App\Http\Controllers\AppController;
use App\Http\Controllers\AppPmsController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SiteController;
use Illuminate\Support\Facades\Route;

// ─── Public booking site ─────────────────────────────────────
Route::get('/', [SiteController::class, 'home'])->name('home');
Route::get('/quartos', [SiteController::class, 'rooms'])->name('rooms');
Route::get('/quartos/{slug}', [SiteController::class, 'roomDetail'])->name('rooms.show');
Route::get('/comodidades', [SiteController::class, 'amenities'])->name('amenities');
Route::get('/sobre', [SiteController::class, 'about'])->name('about');
Route::get('/contato', [SiteController::class, 'contact'])->name('contact');

// ─── Auth (guest only) ───────────────────────────────────────
Route::middleware('guest.mock')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
    Route::get('/registro', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/registro', [AuthController::class, 'register'])->name('register.submit');
    Route::get('/esqueci-senha', [AuthController::class, 'showForgotPassword'])->name('password.request');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ─── App (PMS — auth-gated, mock) ────────────────────────────
Route::middleware('auth.mock')->group(function () {
    Route::get('/app', [AppController::class, 'dashboard'])->name('dashboard');
    Route::get('/app/reservas', [AppPmsController::class, 'reservations'])->name('app.reservations');
    Route::get('/app/mapa', [AppPmsController::class, 'roomMap'])->name('app.room-map');
    Route::get('/app/checkin', [AppPmsController::class, 'checkin'])->name('app.checkin');
    Route::get('/app/hospedes', [AppPmsController::class, 'guests'])->name('app.guests');
    Route::get('/app/tarifas', [AppPmsController::class, 'rates'])->name('app.rates');
    Route::get('/app/configuracoes', [AppController::class, 'settings'])->name('app.settings');
});

// ─── Fallback 404 ────────────────────────────────────────────
Route::fallback(fn () => response()->view('pages.public.not-found', ['pageTitle' => '404'], 404));
