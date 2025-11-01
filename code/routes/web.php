<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UomController;
use App\Http\Controllers\ItemController;

Route::view('/', 'welcome');

// Health check endpoint
Route::get('/health', function () {
    return response('OK', 200)
        ->header('Content-Type', 'text/plain');
});

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

// User Management Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/users', [UserManagementController::class, 'index'])->name('users.index');
});

// Supplier Management Routes
Route::middleware(['auth'])->group(function () {
    Route::get('suppliers', [SupplierController::class, 'index'])
        ->middleware('can:suppliers.read')
        ->name('suppliers.index');
    
    Route::get('suppliers/create', [SupplierController::class, 'create'])
        ->middleware('can:suppliers.create')
        ->name('suppliers.create');
    
    Route::post('suppliers', [SupplierController::class, 'store'])
        ->middleware('can:suppliers.create')
        ->name('suppliers.store');
    
    Route::get('suppliers/{supplier}', [SupplierController::class, 'show'])
        ->middleware('can:suppliers.read')
        ->name('suppliers.show');
    
    Route::get('suppliers/{supplier}/edit', [SupplierController::class, 'edit'])
        ->middleware('can:suppliers.update')
        ->name('suppliers.edit');
    
    Route::put('suppliers/{supplier}', [SupplierController::class, 'update'])
        ->middleware('can:suppliers.update')
        ->name('suppliers.update');
    
    Route::patch('suppliers/{supplier}', [SupplierController::class, 'update'])
        ->middleware('can:suppliers.update');
    
    Route::delete('suppliers/{supplier}', [SupplierController::class, 'destroy'])
        ->middleware('can:suppliers.delete')
        ->name('suppliers.destroy');
});

// UOM (Units of Measure) Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/inventory/uoms', App\Livewire\Inventory\Uoms\UomsIndex::class)->name('uoms.index');
    Route::get('/inventory/uoms/create', [UomController::class, 'create'])->name('uoms.create');
    Route::get('/inventory/uoms/{uom}/edit', [UomController::class, 'edit'])->name('uoms.edit');
    // Test route
    Route::get('/inventory/uoms/test', function() {
        return view('uoms.test');
    })->name('uoms.test');
});

// Item Management Routes
Route::middleware(['auth'])->group(function () {
    Route::resource('items', ItemController::class);
});

require __DIR__.'/auth.php';
