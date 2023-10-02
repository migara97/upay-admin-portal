<?php

use App\Enums\Permission;
use App\Livewire\Backend\Dashboard;
use App\Livewire\Backend\Management\AppUserManagement;
use App\Livewire\Backend\MisReport\AdminCreation;
use App\Livewire\Backend\MisReport\AppUserList;
use App\Livewire\Backend\Transaction\LankaQr;
use App\Livewire\Backend\Transaction\Payment;
use App\Livewire\Backend\Transaction\Refund;
use Illuminate\Support\Facades\Route;

// Route::get('dashboard', Dashboard::class)->name('dashboard');
Route::get('dashboard', \App\Livewire\Backend\Dashboard::class)->name('dashboard');

//User management
Route::prefix('user-management')->group(function () {
    Route::get('/users', \App\Livewire\Backend\UserManagment\UserManagment::class)->name('user-managment.user');
});

//Role management
Route::group(['prefix' => 'role-management', 'middleware' => []], function () {
    Route::get('/roles', \App\Livewire\Backend\UserManagment\RoleManagment::class)->name('role-managment.role');
});

//Report routes
Route::group(['prefix' => 'reports', 'as' => 'reports.'], function () {
    Route::get('admin-users', AdminCreation::class)->name('admin-creation');
    Route::get('app-user', AppUserList::class)->name('appUser');
});

//Management
Route::group(['prefix' => 'management', 'as' => 'management.'], function () {
    Route::get('/app-user', AppUserManagement::class)->name('app-user');  
});

//transactions routes
Route::prefix('transactions')->group(function () {
    Route::get('/payment', Payment::class)->name('transactions.payment');
    Route::get('/lanka-qr', LankaQr::class)->name('transactions.lanka-qr');
    Route::get('/refund', Refund::class)->name('transactions.refund');
});