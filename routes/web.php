<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect('login');
});

Route::get('login', \App\Livewire\Auth\Login::class)->name('login');


Route::get('logout', function (){
    auth()->logout();
    return redirect('login');
});
/*
 * Backend Routes
 * Namespaces indicate folder structure
 */
Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['admin','throttle:100,5']], function () {
    /*
     * These routes need view-backend permission
     * (good if you want to allow more than one group in the backend,
     * then limit the backend features by different roles or permissions)
     *
     * Note: Administrator has all permissions so you do not have to specify the administrator role everywhere.
     * These routes can not be hit if the password is expired
     */
    include_route_files(__DIR__.'/backend/');
});
