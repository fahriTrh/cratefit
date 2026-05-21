<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\KuratorController;
use App\Http\Controllers\KurirController;
use App\Http\Controllers\PaketController;
use App\Http\Controllers\StatusBoxController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['guest'])->group(function () {
    // admin auth
    Route::get('/admin/login',  [AuthController::class, 'showLogin'])->name('admin.login');
    Route::post('/admin/login', [AuthController::class, 'login'])->name('admin.login.post');
    Route::post('/admin/logout', [AuthController::class, 'logout'])->name('admin.logout');
});



Route::middleware(['auth'])->group(function () {
    // customers
    Route::get('/preferensi', function () {
        $currentStep = 2;
        return view('customers.preferensi', compact('currentStep'));
    });

    Route::get('/alamat', function () {
        $currentStep = 3;
        return view('customers.alamat', compact('currentStep'));
    });

    Route::get('/langganan', function () {
        $currentStep = 4;
        return view('customers.langganan', compact('currentStep'));
    });

    Route::get('/status-box', function () {
        return view('customers.status-box');
    });

    Route::get('/retur', function () {
        return view('customers.retur');
    });

    // end customers


    // kurator

    Route::get('/kurator/pelanggan', function () {
        return view('kurators.list-pelanggan');
    });

    Route::get('/kurator/pelanggan/{id}', function () {
        return view('kurators.detail-pelanggan');
    });

    Route::get('/kurator/pilih-item/{id}', function () {
        return view('kurators.pilih-item');
    });

    Route::get('/kurator/susun-box/{id}', function () {
        return view('kurators.susun-box');
    });

    // end kurator


    Route::middleware(['admin'])->group(function () {
        // admin

        Route::get('/admin/dashboard', function () {
            return 'Hello';
        });

        Route::get('/admin/kurator',              [KuratorController::class, 'index']);
        Route::get('/admin/kurator/tambah',       [KuratorController::class, 'create']);
        Route::post('/admin/kurator',             [KuratorController::class, 'store']);
        Route::get('/admin/kurator/{id}',         [KuratorController::class, 'show']);
        Route::get('/admin/kurator/{id}/edit',    [KuratorController::class, 'edit']);
        Route::put('/admin/kurator/{id}',         [KuratorController::class, 'update']);
        Route::delete('/admin/kurator/{id}', [KuratorController::class, 'destroy']);

        Route::get('/admin/pelanggan', function () {
            return view('admins.list-pelanggan');
        });

        Route::get('/admin/pelanggan/{id}', function () {
            return view('admins.detail-pelanggan');
        });

        Route::get('/admin/kurir',                        [KurirController::class, 'index']);
        Route::get('/admin/kurir/tambah',                 [KurirController::class, 'create']);
        Route::post('/admin/kurir',                       [KurirController::class, 'store']);
        Route::get('/admin/kurir/{id}',                   [KurirController::class, 'show']);
        Route::delete('/admin/kurir/{id}',                [KurirController::class, 'destroy']);
        Route::patch('/admin/kurir/{id}/toggle-status',   [KurirController::class, 'toggleStatus']);
        Route::get('/admin/kurir/{id}/edit',  [KurirController::class, 'edit']);
        Route::put('/admin/kurir/{id}',       [KurirController::class, 'update']);

        Route::get('/admin/kelola-paket',            [PaketController::class, 'index']);
        Route::post('/admin/paket',                  [PaketController::class, 'store']);
        Route::put('/admin/paket/{id}',              [PaketController::class, 'update']);
        Route::delete('/admin/paket/{id}',           [PaketController::class, 'destroy']);
        Route::patch('/admin/paket/{id}/toggle',     [PaketController::class, 'toggle']);

        Route::get('/admin/inventory',              [InventoryController::class, 'index']);
        Route::post('/admin/inventory',                    [InventoryController::class, 'store']);
        Route::put('/admin/inventory/{id}',                [InventoryController::class, 'update']);
        Route::delete('/admin/inventory/{id}',             [InventoryController::class, 'destroy']);
        Route::patch('/admin/inventory/{id}/stok',         [InventoryController::class, 'updateStok']);

        Route::get('/admin/kelola-retur', function () {
            return view('admins.kelola-retur');
        });

        // end admin
    });
});
