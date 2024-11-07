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

Route::get('/devices', [DeviceController::class, 'index'])->name('devices.index');
Route::get('/devices/create', [DeviceController::class, 'create'])->name('devices.create');
Route::post('/devices', [DeviceController::class, 'store'])->name('devices.store');


Route::get('/statuses', [StatusController::class, 'index'])->name('statuses.index');
Route::get('/statuses/create', [StatusController::class, 'create'])->name('statuses.create');
Route::post('/statuses', [StatusController::class, 'store'])->name('statuses.store');


Route::get('/assets', [AssetController::class, 'index'])->name('assets.index');
Route::get('/assets/create', [AssetController::class, 'create'])->name('assets.create');
Route::post('assets', [AssetController::class, 'store'])->name('assets.store');


Route::get('/iotapplications', [IotApplicationController::class, 'index'])->name('iotapplications.index');
Route::get('/iotapplications/create', [IotApplicationController::class, 'create'])->name('iotapplications.create');
Route::post('/iotapplications', [IotApplicationController::class, 'store'])->name('iotapplications.store');
// Route::get('/assets/{asset}/edit', [AssetController::class, 'edit'])->name('assets.edit');


});