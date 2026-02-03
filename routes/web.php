<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Vulnerabilities\A01Controller;
use App\Http\Controllers\Vulnerabilities\A02Controller;
use App\Http\Controllers\Vulnerabilities\A03Controller;
use App\Http\Controllers\Vulnerabilities\A04Controller;
use App\Http\Controllers\Vulnerabilities\A05Controller;
use App\Http\Controllers\Vulnerabilities\A06Controller;
use App\Http\Controllers\Vulnerabilities\A07Controller;
use App\Http\Controllers\Vulnerabilities\A08Controller;
use App\Http\Controllers\Vulnerabilities\A09Controller;
use App\Http\Controllers\Vulnerabilities\A10Controller;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Protected Routes (require authentication)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | A01: Broken Access Control
    |--------------------------------------------------------------------------
    */
    Route::prefix('a01')->group(function () {
        // VULNERABLE: No role middleware - any user can access
        Route::get('/vulnerable', [A01Controller::class, 'vulnerable'])->name('a01.vulnerable');
        Route::get('/vulnerable/profile/{id}', [A01Controller::class, 'vulnerableProfile'])->name('a01.vulnerable.profile');
        
        // SECURE: Protected with role middleware
        Route::get('/secure', [A01Controller::class, 'secure'])->middleware('role:admin')->name('a01.secure');
        Route::get('/secure/profile/{id}', [A01Controller::class, 'secureProfile'])->name('a01.secure.profile');
    });

    /*
    |--------------------------------------------------------------------------
    | A02: Cryptographic Failures
    |--------------------------------------------------------------------------
    */
    Route::prefix('a02')->group(function () {
        Route::match(['get', 'post'], '/vulnerable', [A02Controller::class, 'vulnerable'])->name('a02.vulnerable');
        Route::match(['get', 'post'], '/secure', [A02Controller::class, 'secure'])->name('a02.secure');
    });

    /*
    |--------------------------------------------------------------------------
    | A03: Injection (SQL Injection)
    |--------------------------------------------------------------------------
    */
    Route::prefix('a03')->group(function () {
        Route::get('/vulnerable', [A03Controller::class, 'vulnerable'])->name('a03.vulnerable');
        Route::get('/secure', [A03Controller::class, 'secure'])->name('a03.secure');
    });

    /*
    |--------------------------------------------------------------------------
    | A04: Insecure Design
    |--------------------------------------------------------------------------
    */
    Route::prefix('a04')->group(function () {
        Route::match(['get', 'post'], '/vulnerable', [A04Controller::class, 'vulnerable'])->name('a04.vulnerable');
        Route::match(['get', 'post'], '/secure', [A04Controller::class, 'secure'])->name('a04.secure');
    });

    /*
    |--------------------------------------------------------------------------
    | A05: Security Misconfiguration
    |--------------------------------------------------------------------------
    */
    Route::prefix('a05')->group(function () {
        Route::get('/vulnerable', [A05Controller::class, 'vulnerable'])->name('a05.vulnerable');
        Route::get('/secure', [A05Controller::class, 'secure'])->name('a05.secure');
    });

    /*
    |--------------------------------------------------------------------------
    | A06: Vulnerable and Outdated Components
    |--------------------------------------------------------------------------
    */
    Route::prefix('a06')->group(function () {
        Route::get('/', [A06Controller::class, 'index'])->name('a06.index');
    });

    /*
    |--------------------------------------------------------------------------
    | A07: Identification and Authentication Failures
    |--------------------------------------------------------------------------
    */
    Route::prefix('a07')->group(function () {
        Route::match(['get', 'post'], '/vulnerable', [A07Controller::class, 'vulnerable'])->name('a07.vulnerable');
        Route::match(['get', 'post'], '/secure', [A07Controller::class, 'secure'])->name('a07.secure');
    });

    /*
    |--------------------------------------------------------------------------
    | A08: Software and Data Integrity Failures
    |--------------------------------------------------------------------------
    */
    Route::prefix('a08')->group(function () {
        Route::match(['get', 'post'], '/vulnerable', [A08Controller::class, 'vulnerable'])->name('a08.vulnerable');
        Route::match(['get', 'post'], '/secure', [A08Controller::class, 'secure'])->name('a08.secure');
    });

    /*
    |--------------------------------------------------------------------------
    | A09: Security Logging and Monitoring Failures
    |--------------------------------------------------------------------------
    */
    Route::prefix('a09')->group(function () {
        Route::match(['get', 'post'], '/vulnerable', [A09Controller::class, 'vulnerable'])->name('a09.vulnerable');
        Route::match(['get', 'post'], '/secure', [A09Controller::class, 'secure'])->name('a09.secure');
    });

    /*
    |--------------------------------------------------------------------------
    | A10: Server-Side Request Forgery (SSRF)
    |--------------------------------------------------------------------------
    */
    Route::prefix('a10')->group(function () {
        Route::match(['get', 'post'], '/vulnerable', [A10Controller::class, 'vulnerable'])->name('a10.vulnerable');
        Route::match(['get', 'post'], '/secure', [A10Controller::class, 'secure'])->name('a10.secure');
    });
});
