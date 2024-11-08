<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\IotApplicationController;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', function () {
    return view('adminlte::page');
})->middleware('auth');

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard'); // Ensure you have a 'resources/views/dashboard.blade.php' file
    })->name('dashboard');

    Route::get('/devices', [DeviceController::class, 'index'])->name('devices.index');
    Route::get('/devices/create', [DeviceController::class, 'create'])->name('devices.create');
    Route::post('/devices', [DeviceController::class, 'store'])->name('devices.store');
    Route::get('/devices/{device}/edit', [DeviceController::class, 'edit'])->name('devices.edit');
    Route::put('/devices/{device}', [DeviceController::class, 'update'])->name('devices.update');
    Route::delete('/devices/{device}', [DeviceController::class, 'destroy'])->name('devices.destroy');

    Route::get('/statuses', [StatusController::class, 'index'])->name('statuses.index');
    Route::get('/statuses/create', [StatusController::class, 'create'])->name('statuses.create');
    Route::post('/statuses', [StatusController::class, 'store'])->name('statuses.store');
    Route::get('/statuses/{status}/edit', [StatusController::class, 'edit'])->name('statuses.edit');
    Route::put('/statuses/{status}', [StatusController::class, 'update'])->name('statuses.update');
    Route::delete('/statuses/{status}', [StatusController::class, 'destroy'])->name('statuses.destroy');



    Route::get('/assets', [AssetController::class, 'index'])->name('assets.index');
    Route::get('/assets/create', [AssetController::class, 'create'])->name('assets.create');
    Route::post('assets', [AssetController::class, 'store'])->name('assets.store');
    Route::get('/assets/{asset}/edit', [AssetController::class, 'edit'])->name('assets.edit');
    Route::put('/assets/{asset}', [AssetController::class, 'update'])->name('assets.update');
    Route::delete('/assets/{asset}', [AssetController::class, 'destroy'])->name('assets.destroy');


    Route::get('/iotapplications', [IotApplicationController::class, 'index'])->name('iotapplications.index');
    Route::get('/iotapplications/create', [IotApplicationController::class, 'create'])->name('iotapplications.create');
    Route::post('/iotapplications', [IotApplicationController::class, 'store'])->name('iotapplications.store');
    Route::get('/iotapplications/{iotapplication}/edit', [IotApplicationController::class, 'edit'])->name('iotapplications.edit');
    Route::put('/iotapplications/{iotapplication}', [IotApplicationController::class, 'update'])->name('iotapplications.update');
    Route::delete('/iotapplications/{iotapplication}', [IotApplicationController::class, 'destroy'])->name('iotapplications.destroy');

});

require __DIR__.'/auth.php';