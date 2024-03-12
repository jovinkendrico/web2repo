<?php

use App\Http\Controllers\BarangController;
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

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';


// proteksi route dengan middlware auth
// https://laravel.com/docs/10.x/authentication#protecting-routes
Route::middleware('auth')->group(function() {
    // route barang sekarang berada di bawah route /admin
    Route::prefix('/admin')->name('admin.')->group(function() {
    Route::controller(BarangController::class)->prefix('/barang')
                                              ->name('barang.')
                                              ->group(function() {
        Route::get('/', 'index')->name('index');
        Route::get('/new', 'new')->name('new');
        Route::post('/', 'create')->name('create');
        Route::get('/{id}', 'show')->name('show');
        Route::get('/edit/{id}', 'edit')->name('edit');
        Route::post('/edit/{id}', 'update')->name('update');
        Route::get('/delete/{id}', 'delete')->name('delete');
    });

    });
});
