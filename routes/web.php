<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\CreditApplicationController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\EconomicSectorController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/about', function () {
    return view('about'); 
})->name('About');

Route::get('/contact us', function () {
    return view('contact us'); 
})->name('contact us');

Route::get('auth/google', [GoogleController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Rute untuk Kredit
    Route::resource('applications', CreditApplicationController::class);
    // Rute baru untuk melihat draft aplikasi
    Route::get('/applications/drafts', [CreditApplicationController::class, 'drafts'])->name('applications.drafts');
    // Rute baru untuk update status aplikasi (Approved/Rejected)
    Route::put('/applications/{application}/update-status', [CreditApplicationController::class, 'updateStatus'])->name('applications.update-status');


    // Rute untuk Manajemen Pengguna (Hanya Admin)
    Route::resource('users', UserController::class);

    // Rute untuk Laporan
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');

    // Rute untuk Manajemen Sektor Ekonomi (Data Master)
    Route::resource('economic-sectors', EconomicSectorController::class)->middleware('can:manage master data');
});

require __DIR__.'/auth.php';
