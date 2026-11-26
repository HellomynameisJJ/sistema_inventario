<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\InventoryItemController;
use App\Http\Controllers\LibraryController;
use App\Http\Controllers\TicController;
use App\Http\Controllers\AipController;
use App\Http\Controllers\LaboratoryController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MyProfileController;
use App\Http\Controllers\DashboardController;

// ==========================================
// 1. RUTAS PÚBLICAS Y DE AUTENTICACIÓN
// ==========================================
Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// ==========================================
// 2. RUTAS PROTEGIDAS (Requieren inicio de sesión)
// ==========================================
Route::middleware(['auth'])->group(function () {

    // Configuración de tema multi-usuario
    Route::post('/user/update-theme', [UserController::class, 'updateTheme'])->name('user.update-theme');

    // Mi perfil (usuario autenticado)
    Route::get('/mi-perfil', [MyProfileController::class, 'edit'])->name('my-profile.edit');
    Route::put('/mi-perfil', [MyProfileController::class, 'update'])->name('my-profile.update');

    // Redirección inicial según rol
    Route::get('/dashboard-redirect', function () {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        return match ((int) $user->rol_id) {
            2 => redirect()->route('library.index'),
            3 => redirect()->route('inventory.index'),
            4 => redirect()->route('tic.index'),
            5 => redirect()->route('aip.index'),
            6 => redirect()->route('laboratory.index'),
            default => redirect()->route('inventory.dashboard'),
        };
    })->name('dashboard.redirect');

    // ==========================================
    // 3. MÓDULO BIBLIOTECA ESCOLAR
    // ==========================================
    Route::middleware(['module:library'])->prefix('library')->name('library.')->group(function () {
        Route::get('/', [LibraryController::class, 'index'])->name('index');
        Route::post('/', [LibraryController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [LibraryController::class, 'edit'])->name('edit');
        Route::put('/{id}', [LibraryController::class, 'update'])->name('update');
        Route::delete('/{id}', [LibraryController::class, 'destroy'])->name('destroy');
    });

    // ==========================================
    // 4. MÓDULO MOBILIARIO Y AULAS
    // ==========================================
    Route::middleware(['module:inventory'])->prefix('inventory')->name('inventory.')->group(function () {
        Route::get('/', [InventoryItemController::class, 'index'])->name('index');
        Route::post('/', [InventoryItemController::class, 'store'])->name('store');
        Route::post('/import-csv', [InventoryItemController::class, 'importCsv'])->name('import');
        Route::get('/{id}/edit', [InventoryItemController::class, 'edit'])->name('edit');
        Route::put('/{id}', [InventoryItemController::class, 'update'])->name('update');
        Route::delete('/{id}', [InventoryItemController::class, 'destroy'])->name('destroy');
    });

    // ==========================================
    // 5. MÓDULO EQUIPOS TIC
    // ==========================================
    Route::middleware(['module:tic'])->prefix('tic')->name('tic.')->group(function () {
        Route::get('/', [TicController::class, 'index'])->name('index');
        Route::post('/', [TicController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [TicController::class, 'edit'])->name('edit');
        Route::put('/{id}', [TicController::class, 'update'])->name('update');
        Route::delete('/{id}', [TicController::class, 'destroy'])->name('destroy');
    });

    // ==========================================
    // 6. MÓDULO AULA AIP
    // ==========================================
    Route::middleware(['module:aip'])->prefix('aip')->name('aip.')->group(function () {
        Route::get('/', [AipController::class, 'index'])->name('index');
        Route::post('/', [AipController::class, 'store'])->name('store');
        Route::delete('/{id}', [AipController::class, 'destroy'])->name('destroy');
    });

    // ==========================================
    // 7. MÓDULO LABORATORIO
    // ==========================================
    Route::middleware(['module:laboratory'])->prefix('laboratory')->name('laboratory.')->group(function () {
        Route::get('/', [LaboratoryController::class, 'index'])->name('index');
        Route::post('/', [LaboratoryController::class, 'store'])->name('store');
        Route::delete('/{id}', [LaboratoryController::class, 'destroy'])->name('destroy');
    });

    // ==========================================
    // 8. DASHBOARD GENERAL Y GESTIÓN DE PERFILES
    // ==========================================
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('inventory.dashboard');
    Route::get('/inventory-objetos', [DashboardController::class, 'objetos'])->name('inventory.objetos');

    Route::prefix('profiles')->name('profiles.')->group(function () {
        Route::get('/', [ProfileController::class, 'index'])->name('index');
        Route::get('/{id}/edit', [ProfileController::class, 'edit'])->name('edit');
        Route::put('/{id}', [ProfileController::class, 'update'])->name('update');
        Route::put('/{id}/access', [ProfileController::class, 'updateAccess'])->name('update-access');
    });

});