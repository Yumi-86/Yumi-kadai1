<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ContactController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
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

Route::get('/', [ContactController::class, 'create']);
Route::post('/confirm', [ContactController::class, 'confirm']);
Route::post('/', [ContactController::class, 'edit']);
Route::post('/thanks', [ContactController::class, 'store']);
Route::middleware('auth')->group(function () {
    Route::get('/admin', [AdminController::class, 'index']);
});
Route::post('/admin', [AdminController::class, 'search']);
Route::delete('/admin', [AdminController::class, 'destroy']);
Route::get('/admin/export', [AdminController::class, 'export']);

Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store']);
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy']);
