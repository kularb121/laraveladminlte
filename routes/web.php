<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\AssetSiteController;
use App\Http\Controllers\DeviceAssetController;
use App\Http\Controllers\IotApplicationController;

Route::get('/', function () {
    return view('adminlte::page');
})->middleware('auth');

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::resource('roles', RoleController::class);
    Route::resource('sites', SiteController::class);
    Route::resource('assets', AssetController::class);
    Route::resource('devices', DeviceController::class);
    Route::resource('statuses', StatusController::class);
    Route::resource('customers', CustomerController::class);
    Route::resource('asset_sites', AssetSiteController::class);
    Route::resource('device_assets', DeviceAssetController::class);
    Route::resource('iotapplications', IotApplicationController::class);

    Route::resource('users', UserController::class);
    Route::get('/users/manage-roles', [UserController::class, 'manageRoles'])->name('users.manage-roles');
    Route::get('/users/{user}/edit-role', [UserController::class, 'editRole'])->name('users.editRole');
    Route::put('/users/{user}/update-role', [UserController::class, 'updateRole'])->name('users.updateRole');
    


    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/profile/change-password', [ProfileController::class, 'showChangePasswordForm'])->name('profile.change-password');
    Route::post('/profile/change-password', [ProfileController::class, 'changePassword'])->name('profile.change-password.update');

    // Route::get('/users/{user}/edit-role', [UserController::class, 'editRole'])->name('users.editRole');
    // Route::put('/users/{user}/update-role', [UserController::class, 'updateRole'])->name('users.updateRole');
});

require __DIR__.'/auth.php';



// Code before 07.
// Route::middleware(['auth'])->group(function () {
//     Route::get('/dashboard', function () {
//         return view('dashboard'); // Ensure you have a 'resources/views/dashboard.blade.php' file
//     })->name('dashboard');

//     Route::get('/devices', [DeviceController::class, 'index'])->name('devices.index');
//     Route::get('/devices/create', [DeviceController::class, 'create'])->name('devices.create');
//     Route::post('/devices', [DeviceController::class, 'store'])->name('devices.store');
//     Route::get('/devices/{device}/edit', [DeviceController::class, 'edit'])->name('devices.edit');
//     Route::put('/devices/{device}', [DeviceController::class, 'update'])->name('devices.update');
//     Route::delete('/devices/{device}', [DeviceController::class, 'destroy'])->name('devices.destroy');

//     Route::get('/statuses', [StatusController::class, 'index'])->name('statuses.index');
//     Route::get('/statuses/create', [StatusController::class, 'create'])->name('statuses.create');
//     Route::post('/statuses', [StatusController::class, 'store'])->name('statuses.store');
//     Route::get('/statuses/{status}/edit', [StatusController::class, 'edit'])->name('statuses.edit');
//     Route::put('/statuses/{status}', [StatusController::class, 'update'])->name('statuses.update');
//     Route::delete('/statuses/{status}', [StatusController::class, 'destroy'])->name('statuses.destroy');



//     Route::get('/assets', [AssetController::class, 'index'])->name('assets.index');
//     Route::get('/assets/create', [AssetController::class, 'create'])->name('assets.create');
//     Route::post('assets', [AssetController::class, 'store'])->name('assets.store');
//     Route::get('/assets/{asset}/edit', [AssetController::class, 'edit'])->name('assets.edit');
//     Route::put('/assets/{asset}', [AssetController::class, 'update'])->name('assets.update');
//     Route::delete('/assets/{asset}', [AssetController::class, 'destroy'])->name('assets.destroy');

//     Route::get('/device_assets', [DeviceAssetController::class, 'index'])->name('device_assets.index');
//     Route::get('/device_assets/create', [DeviceAssetController::class, 'create'])->name('device_assets.create');
//     Route::post('device_assets', [DeviceAssetController::class, 'store'])->name('device_assets.store');
//     Route::get('/device_assets/{device_asset}/edit', [DeviceAssetController::class, 'edit'])->name('device_assets.edit');
//     Route::put('/device_assets/{device_asset}', [DeviceAssetController::class, 'update'])->name('device_assets.update');
//     Route::delete('/device_assets/{device_asset}', [DeviceAssetController::class, 'destroy'])->name('device_assets.destroy');


//     Route::get('/iotapplications', [IotApplicationController::class, 'index'])->name('iotapplications.index');
//     Route::get('/iotapplications/create', [IotApplicationController::class, 'create'])->name('iotapplications.create');
//     Route::post('/iotapplications', [IotApplicationController::class, 'store'])->name('iotapplications.store');
//     Route::get('/iotapplications/{iotapplication}/edit', [IotApplicationController::class, 'edit'])->name('iotapplications.edit');
//     Route::put('/iotapplications/{iotapplication}', [IotApplicationController::class, 'update'])->name('iotapplications.update');
//     Route::delete('/iotapplications/{iotapplication}', [IotApplicationController::class, 'destroy'])->name('iotapplications.destroy');

//     Route::get('/sites', [SiteController::class, 'index'])->name('sites.index');
//     Route::get('/sites/create', [SiteController::class, 'create'])->name('sites.create');
//     Route::post('sites', [SiteController::class, 'store'])->name('sites.store');
//     Route::get('/sites/{site}/edit', [SiteController::class, 'edit'])->name('sites.edit');
//     Route::put('/sites/{site}', [SiteController::class, 'update'])->name('sites.update');
//     Route::delete('/sites/{site}', [SiteController::class, 'destroy'])->name('sites.destroy');

//     Route::get('/customers', [CustomerController::class, 'index'])->name('customers.index');
//     Route::get('/customers/create', [CustomerController::class, 'create'])->name('customers.create');
//     Route::post('customers', [CustomerController::class, 'store'])->name('customers.store');
//     Route::get('/customers/{customer}/edit', [CustomerController::class, 'edit'])->name('customers.edit');
//     Route::put('/customers/{customer}', [CustomerController::class, 'update'])->name('customers.update');
//     Route::delete('/customers/{customer}', [CustomerController::class, 'destroy'])->name('customers.destroy');

//     Route::get('/asset_sites', [AssetSiteController::class, 'index'])->name('asset_sites.index');
//     Route::get('/asset_sites/create', [AssetSiteController::class, 'create'])->name('asset_sites.create');
//     Route::post('asset_sites', [AssetSiteController::class, 'store'])->name('asset_sites.store');
//     Route::get('/asset_sites/{assetSite}/edit', [AssetSiteController::class, 'edit'])->name('asset_sites.edit');
//     Route::put('/asset_sites/{assetSite}', [AssetSiteController::class, 'update'])->name('asset_sites.update');
//     Route::delete('/asset_sites/{assetSite}', [AssetSiteController::class, 'destroy'])->name('asset_sites.destroy');

//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
//     Route::get('/profile/change-password', [ProfileController::class, 'showChangePasswordForm'])->name('profile.change-password');
//     Route::post('/profile/change-password', [ProfileController::class, 'changePassword'])->name('profile.change-password.update');

// });

// // Other resource routes allow them to accept parameters.
// Route::resource('sites', SiteController::class);
// Route::resource('assets', AssetController::class);
// Route::resource('devices', DeviceController::class);
// Route::resource('statuses', StatusController::class);
// Route::resource('customers', CustomerController::class);
// Route::resource('asset_sites', AssetSiteController::class);
// Route::resource('device_assets', DeviceAssetController::class);
// Route::resource('iotapplications', IotApplicationController::class);
// Route::resource('roles', RoleController::class);