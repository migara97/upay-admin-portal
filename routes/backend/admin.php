<?php

use App\Livewire\Backend\Dashboard;
use Illuminate\Support\Facades\Route;

// Route::get('dashboard', Dashboard::class)->name('dashboard');
Route::get('dashboard', \App\Livewire\Backend\Dashboard::class)->name('dashboard');