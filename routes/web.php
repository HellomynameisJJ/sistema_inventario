<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\InventoryItemController;
use App\Http\Controllers\LibraryController;
use App\Http\Controllers\TicController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
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

    // --- CONFIGURACIÓN DE TEMA MULTI-USUARIO ---
    Route::post('/user/update-theme', [UserController::class, 'updateTheme'])->name('user.update-theme');

    // --- REDIRECCIÓN INICIAL INTELIGENTE SEGÚN ROL ---
    Route::get('/dashboard-redirect', function () {
        $user = Auth::user();
        
        if ($user) {
            switch ($user->rol_id) {
                case 2: // Biblioteca Escolar
                    return redirect()->route('library.index');
                case 3: // Mobiliario y Aulas
                    return redirect()->route('inventory.index');
                case 4: // Equipos TIC
                    return redirect()->route('tic.index');
                case 5: // Aula AIP
                    return redirect()->route('tic.index');
                case 1: // Administrador
                default:
                    return redirect()->route('inventory.dashboard');
            }
        }

        return redirect()->route('login');
    })->name('dashboard.redirect');


    // ==========================================
    // 3. MÓDULO BIBLIOTECA ESCOLAR (Rol ID: 1 o 2)
    // ==========================================
    Route::get('/library', [LibraryController::class, 'index'])->name('library.index');
    Route::post('/library', [LibraryController::class, 'store'])->name('library.store');
    Route::get('/library/{id}/edit', [LibraryController::class, 'edit'])->name('library.edit');
    Route::put('/library/{id}', [LibraryController::class, 'update'])->name('library.update');
    Route::delete('/library/{id}', [LibraryController::class, 'destroy'])->name('library.destroy');


    // ==========================================
    // 4. MÓDULO MOBILIARIO Y AULAS (Rol ID: 1 o 3)
    // ==========================================
    Route::get('/inventory', [InventoryItemController::class, 'index'])->name('inventory.index');
    Route::post('/inventory', [InventoryItemController::class, 'store'])->name('inventory.store');
    Route::get('/inventory/{id}/edit', [InventoryItemController::class, 'edit'])->name('inventory.edit');
    Route::put('/inventory/{id}', [InventoryItemController::class, 'update'])->name('inventory.update');
    Route::delete('/inventory/{id}', [InventoryItemController::class, 'destroy'])->name('inventory.destroy');
    Route::post('/inventory/import-csv', [InventoryItemController::class, 'importCsv'])->name('inventory.import');


    // ==========================================
    // 5. MÓDULO EQUIPOS TIC Y AIP (Rol ID: 1, 4 o 5)
    // ==========================================
    Route::get('/tic', [TicController::class, 'index'])->name('tic.index');
    Route::post('/tic', [TicController::class, 'store'])->name('tic.store');
    Route::get('/tic/{id}/edit', [TicController::class, 'edit'])->name('tic.edit');
    Route::put('/tic/{id}', [TicController::class, 'update'])->name('tic.update');
    Route::delete('/tic/{id}', [TicController::class, 'destroy'])->name('tic.destroy');


    // ==========================================
    // 6. DASHBOARD GENERAL Y GESTIÓN DE ACCESOS (Solo Administrador: Rol ID 1)
    // ==========================================
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('inventory.dashboard');
    Route::get('/inventory/objetos', [DashboardController::class, 'objetos'])->name('inventory.objetos');
    Route::get('/profiles', [ProfileController::class, 'index'])->name('profiles.index');
    Route::put('/profiles/{id}/access', [ProfileController::class, 'updateAccess'])->name('profiles.update-access');

});