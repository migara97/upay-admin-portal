<?php

use App\Livewire\Backend\Dashboard;
use App\Livewire\Backend\MisReport\AdminCreation;
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
});
