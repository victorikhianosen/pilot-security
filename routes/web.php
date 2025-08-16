<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;


Route::get('/', [PageController::class, 'index'])->name('home');
Route::get('login', [AuthController::class, 'login'])->middleware('guest')->name('login');
Route::post('login', [AuthController::class, 'loginStore'])->name('login.store');


Route::get('about', [PageController::class, 'about'])->name('about');
Route::get('team', [PageController::class, 'team'])->name('team');
Route::get('services', [PageController::class, 'services'])->name('services');
Route::get('contact', [PageController::class, 'contact'])->name('contact');

Route::get('nse', [PageController::class, 'nse'])->name('nse');
Route::get('bonds', [PageController::class, 'bonds'])->name('bonds');
Route::get('eft', [PageController::class, 'ETF'])->name('eft');


Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::get('', [DashboardController::class, 'dashboard'])->name('dashboard');
    Route::post('upload/pricing', [DashboardController::class, 'extractPricing'])->name('upload.pricing');


    Route::get('nse/lists', [DashboardController::class, 'nseIndex'])->name('nse.index');



    Route::get('logout', [AuthController::class, 'logout'])->name('logout');
});
