<?php

use App\Http\Controllers\StatusBoxController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

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


// admin

Route::get('/admin/kurator', function () {
    return view('admins.list-kurator');
});

Route::get('/admin/kurator/tambah', function () {
    return view('admins.tambah-kurator');
});

Route::get('/admin/kurator/{id}', function () {
    return view('admins.detail-kurator');
});

Route::get('/admin/kurator/{id}/edit', function () {
    return view('admins.edit-kurator');
});

Route::get('/admin/pelanggan', function () {
    return view('admins.list-pelanggan');
});

Route::get('/admin/pelanggan/{id}', function () {
    return view('admins.detail-pelanggan');
});

Route::get('/admin/kurir', function () {
    return view('admins.list-kurir');
});

Route::get('/admin/kurir/tambah', function () {
    return view('admins.tambah-kurir');
});

Route::get('/admin/kurir/{id}', function () {
    return view('admins.detail-kurir');
});

Route::get('/admin/kelola-paket', function () {
    return view('admins.kelola-paket');
});

Route::get('/admin/kelola-inventory', function () {
    return view('admins.kelola-inventory');
});

// end admin