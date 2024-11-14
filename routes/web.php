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
use App\Http\Controllers\WorkflowController;
use App\Http\Controllers\AssetSiteController;
use App\Http\Controllers\DeviceAssetController;
use App\Http\Controllers\WorkflowStepController;
use App\Http\Controllers\IotApplicationController;

use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Admin\UserRegistrationController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

Route::get('/', function () {
    return view('adminlte::page');
})->middleware('auth');

Route::get('/login', [AuthenticatedSessionController::class, 'create'])
    ->middleware('guest')
    ->name('login');

Route::post('/login', [AuthenticatedSessionController::class, 'store'])
    ->middleware('guest');

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

Route::middleware(['auth'])->group(function () {

    // Resources using UUIDs
    Route::resource('sites', SiteController::class)->parameters(['sites' => 'site:uuid']);
    Route::resource('assets', AssetController::class)->parameters(['assets' => 'asset:uuid']);
    Route::resource('devices', DeviceController::class)->parameters(['devices' => 'device:uuid']);
    Route::resource('customers', CustomerController::class)->parameters(['customers' => 'customer:uuid'])->except(['show']); 
    Route::resource('users', UserController::class)->parameters(['users' => 'user:uuid']); 

    Route::resource('statuses', StatusController::class);
    Route::resource('asset_sites', AssetSiteController::class);
    Route::resource('device_assets', DeviceAssetController::class);
    Route::resource('roles', RoleController::class);
    Route::resource('workflows', WorkflowController::class);
    Route::resource('iotapplications', IotApplicationController::class); 

    // Explicitly define the 'index' and 'create' routes for customers 
    Route::get('/customers', [CustomerController::class, 'index'])->name('customers.index');
    Route::get('/customers/create', [CustomerController::class, 'create'])->name('customers.create');

    // Customer attributes routes
    Route::get('/customers/attributes', [CustomerController::class, 'allAttributes'])->name('customers.attributes.index');
    Route::post('/customers/attributes', [CustomerController::class, 'storeAttribute'])->name('customers.attributes.store');
    Route::get('/customers/attributes/create', [CustomerController::class, 'createAttribute'])->name('customers.attributes.create');

    // Assuming 'Attribute' model uses integer ID
    Route::get('/customers/attributes/{attribute}/edit', [CustomerController::class, 'editAttribute'])->name('customers.attributes.edit');
    Route::put('/customers/attributes/{attribute}', [CustomerController::class, 'updateAttribute'])->name('customers.attributes.update');
    Route::delete('/customers/attributes/{attribute}', [CustomerController::class, 'destroyAttribute'])->name('customers.attributes.destroy');

    // User role management routes
    Route::get('/users/manage-roles', [UserController::class, 'manageRoles'])->name('users.manage-roles');
    Route::get('/users/{user}/edit-role', [UserController::class, 'editRole'])->name('users.editRole');
    Route::put('/users/{user}/update-role', [UserController::class, 'updateRole'])->name('users.updateRole');
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/profile/change-password', [ProfileController::class, 'showChangePasswordForm'])->name('profile.change-password');
    Route::post('/profile/change-password', [ProfileController::class, 'changePassword'])->name('profile.change-password.update');

    
    Route::post('/workflows/{workflow}/assign', [WorkflowController::class, 'assignTask'])->name('workflows.assign');
    Route::post('/workflows/{workflow}/update-status', [WorkflowController::class, 'updateStatus'])->name('workflows.updateStatus');
    Route::post('/workflows/{workflow}/assign', [WorkflowController::class, 'assignTask'])->name('workflows.assign');

    Route::post('/workflows/{workflow}/steps/{step}/reorder', [WorkflowStepController::class, 'reorder'])->name('workflows.steps.reorder');
    
    Route::get('/assets/{asset}/dashboard', [AssetController::class, 'showDashboard'])->name('assets.dashboard');
    Route::get('/assets/{asset}/dashboard/temperature-history/{device}', [AssetController::class, 'temperatureHistory'])->name('assets.dashboard.temperature-history');
    Route::get('/assets/{asset}/download/{device}', [AssetController::class, 'download'])->name('assets.download');

});

Route::middleware(['auth', 'can:edit-user-roles'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/register', [UserRegistrationController::class, 'create'])->name('users.create');
    Route::post('/register', [UserRegistrationController::class, 'store'])->name('users.store');
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    Route::get('/users/{user}/edit-role', [UserController::class, 'editRole'])->name('users.editRole');
    Route::put('/users/{user}/update-role', [UserController::class, 'updateRole'])->name('users.updateRole');
    Route::get('/users/manage-roles', [UserController::class, 'manageRoles'])->name('users.manage-roles');

});

require __DIR__.'/auth.php';