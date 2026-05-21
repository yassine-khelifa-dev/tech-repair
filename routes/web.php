<?php

use App\Http\Controllers\Web\Device\DeviceAttributeController;
use App\Http\Controllers\Web\Device\DeviceModelController;
use App\Http\Controllers\Web\Device\DeviceTypeController;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Web\Device\BrandController;
use App\Http\Controllers\Web\Device\DeviceAttributeOptionController;
use App\Http\Controllers\Web\Device\SpecAttributeController;
use App\Models\SpecAttributeOption;
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

    Route::resource('spec-attribute', SpecAttributeController::class);


});

require __DIR__.'/auth.php';
