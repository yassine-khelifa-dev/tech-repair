<?php

use App\Http\Controllers\Web\Device\DeviceModelController;
use App\Http\Controllers\Web\Device\DeviceTypeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Web\Device\BrandController;
use App\Http\Controllers\Web\Device\DeviceModelConfigurationController;
use App\Http\Controllers\Web\Device\SpecAttributeController;
use App\Http\Controllers\Web\Repair\RepairLogController;
use App\Http\Controllers\Web\Repair\RepairTicketController;
use App\Models\RepairLog;
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
    Route::resource('repair-tickets', RepairTicketController::class);

    // create a repair-ticket log
    Route::post('repair-ticket-logs/{repair_ticket}/create', [RepairLogController::class, 'store'])
        ->name('repair-ticket-logs');

    // config  device model
    Route::get(
        'device-models/{devicemodel}/configuration',
        [DeviceModelConfigurationController::class, 'edit']
    )->name('device-model-configuration.edit');

    Route::put(
        'device-models/{devicemodel}/configuration',
        [DeviceModelConfigurationController::class, 'update']
    )->name('device-model-configuration.update');
});

require __DIR__ . '/auth.php';
