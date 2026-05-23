<?php

use App\Http\Controllers\AlamatController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\KuratorController;
use App\Http\Controllers\KuratorPelangganController;
use App\Http\Controllers\KurirController;
use App\Http\Controllers\LanggananController;
use App\Http\Controllers\PaketController;
use App\Http\Controllers\PreferensiController;
use App\Http\Controllers\StatusBoxController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['guest'])->group(function () {
    // admin auth
    Route::get('/admin/login',  [AuthController::class, 'showLogin'])->name('admin.login');
    Route::post('/admin/login', [AuthController::class, 'login'])->name('admin.login.post');

    // customer auth
    Route::get('/login',  [AuthController::class, 'showLoginPelanggan'])->name('login');
    Route::post('/login', [AuthController::class, 'loginPelanggan'])->name('pelanggan.login.post');

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');

    // curator auth
    Route::get('/kurator/login',  [AuthController::class, 'showLoginKurator'])->name('kurator.login');
    Route::post('/kurator/login', [AuthController::class, 'loginKurator'])->name('kurator.login.post');
});



Route::middleware(['auth'])->group(function () {

    // customers
    Route::get('/preferensi',  [PreferensiController::class, 'index']);
    Route::post('/preferensi', [PreferensiController::class, 'store']);

    Route::get('/alamat',        [AlamatController::class, 'index']);
    Route::post('/alamat',       [AlamatController::class, 'store']);
    Route::get('/alamat/{id}/edit', [AlamatController::class, 'edit'])->name('pelanggan.alamat.edit');
    Route::put('/alamat/{id}',      [AlamatController::class, 'update']);
    Route::delete('/alamat/{id}', [AlamatController::class, 'destroy'])->name('pelanggan.alamat.destroy');


    Route::get('/langganan', [LanggananController::class, 'create'])->name('langganan.create');
    Route::post('/langganan', [LanggananController::class, 'store'])->name('langganan.store');
    Route::get('/langganan/sukses', [LanggananController::class, 'sukses'])->name('langganan.sukses');
    Route::post('/langganan/batalkan', [LanggananController::class, 'batalkan']);
    Route::get('/status-box', [LanggananController::class, 'statusBox'])->name('status-box');

    Route::get('/retur', function () {
        return view('customers.retur');
    });

    Route::post('/logout', [AuthController::class, 'logoutPelanggan'])->name('logout');

    // end customers


    // kurator
    Route::middleware(['kurator'])->group(function () {

        Route::get('/kurator/pelanggan',      [KuratorPelangganController::class, 'index']);
        Route::get('/kurator/pelanggan/{id}', [KuratorPelangganController::class, 'show']);
        Route::get('/kurator/pilih-item/{id}', [KuratorPelangganController::class, 'pilihItem']);
        Route::post('/kurator/pilih-item/{id}', [KuratorPelangganController::class, 'simpanPilihan']);

        Route::get('/kurator/susun-box/{id}',               [KuratorPelangganController::class, 'susunBox']);
        Route::post('/kurator/susun-box/{id}/konfirmasi',   [KuratorPelangganController::class, 'konfirmasiBox']);

        Route::post('/kurator/logout', [AuthController::class, 'logoutKurator'])->name('kurator.logout');
    });
    // end kurator


    Route::middleware(['admin'])->group(function () {
        // admin

        Route::post('/admin/logout', [AuthController::class, 'logout'])->name('admin.logout');

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
