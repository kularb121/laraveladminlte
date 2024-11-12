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


    Route::resource('roles', RoleController::class);
    Route::resource('sites', SiteController::class);
    Route::resource('assets', AssetController::class);
    Route::resource('devices', DeviceController::class);
    Route::resource('statuses', StatusController::class);
    Route::resource('customers', CustomerController::class);
    Route::resource('asset_sites', AssetSiteController::class);
    Route::resource('device_assets', DeviceAssetController::class);
    Route::resource('iotapplications', IotApplicationController::class);
    Route::resource('workflows', WorkflowController::class);

    //manage-roles must come before any other main resource
    Route::get('/users/manage-roles', [UserController::class, 'manageRoles'])->name('users.manage-roles');
    Route::get('/users/{user}/edit-role', [UserController::class, 'editRole'])->name('users.editRole');
    Route::put('/users/{user}/update-role', [UserController::class, 'updateRole'])->name('users.updateRole');
    Route::resource('users', UserController::class);    


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

    // Route::get('/assets/{asset}/dashboard', [AssetController::class, 'showDashboard'])->name('assets.dashboard');
    // Route::get('/assets/{asset}/dashboard', [AssetController::class, 'showDashboard'])->name('assets.dashboard');
});

require __DIR__.'/auth.php';