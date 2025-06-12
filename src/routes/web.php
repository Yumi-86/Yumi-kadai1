<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ContactController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\CustomRegisterController;
use App\Http\Controllers\ProfileController;

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

Route::get('/', [ContactController::class, 'create'])->name('contact.create');
Route::post('/confirm', [ContactController::class, 'confirm'])->name('contact.confirm');
Route::get('/confirm', function () {
    return redirect()->route('contact.create');
});
Route::post('/', [ContactController::class, 'edit'])->name('contact.edit');
Route::post('/thanks', [ContactController::class, 'store'])->name('contact.store');

Route::middleware('auth')->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
    Route::get('/profile', [ProfileController::class, 'create'])->name('profile.create');
    Route::post('/profile', [ProfileController::class, 'store'])->name('profile.store');
});

Route::post('/admin', [AdminController::class, 'search'])->name('admin.search');
Route::delete('/admin', [AdminController::class, 'destroy'])->name('admin.destroy');
Route::get('/admin/export', [AdminController::class, 'export'])->name('admin.export');

Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('auth.login');
Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('auth.store');
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('auth.destory');

// Route::post('/register', [CustomRegisterController::class, 'register']);
