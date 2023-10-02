<?php

use App\Enums\Permission;
use App\Livewire\Backend\BillerManagement\BillerManagement;
use App\Livewire\Backend\BillerManagement\BillerCategoryManagement;;
use App\Livewire\Backend\Dashboard;
use App\Livewire\Backend\Management\AppUserManagement;
use App\Livewire\Backend\MisReport\AdminCreation;
use App\Livewire\Backend\MisReport\AppUserList;
use App\Livewire\Backend\Transaction\LankaQr;
use App\Livewire\Backend\Transaction\FundTransfer;
use App\Livewire\Backend\Transaction\Payment;
use App\Livewire\Backend\Transaction\Refund;
use App\Livewire\Backend\Transaction\CardSettlement;
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
    Route::get('/fund-transfer', FundTransfer::class)->name('transactions.fund-transfer');
    Route::get('/card-settlement', CardSettlement::class)->name('transactions.card-settlement');
    Route::get('/refund', Refund::class)->name('transactions.refund');
});

// Providers management routes
Route::group(['prefix' => 'providers', 'as' => 'providers.'], function () {
    Route::get('biller', BillerManagement::class)->name('biller');
    Route::get('category', BillerCategoryManagement::class)->name('category');
});
