<?php

use App\Http\Controllers\Web\DeviceModelController;
use App\Http\Controllers\Web\DeviceTypeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Web\BrandController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    // Admin Pages:
    Route::resource('brand', BrandController::class);
    Route::resource('devicetype', DeviceTypeController::class);
    Route::resource('devicemodel', DeviceModelController::class);

});

require __DIR__.'/auth.php';
