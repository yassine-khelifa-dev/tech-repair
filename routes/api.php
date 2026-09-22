<?php

use App\Http\Controllers\Api\Device\BrandController;
use App\Http\Controllers\Api\Device\DeviceModelController;
use App\Http\Controllers\Api\Device\DeviceTypeController;
use App\Http\Controllers\Api\Device\SpecAttributeController;
use App\Http\Controllers\Api\Repair\RepairRequestController;
use App\Http\Controllers\Api\Repair\RepairTicketController;
use Illuminate\Support\Facades\Route;


Route::name('api.')->group(function () {
    Route::get('/repair-tickets', [RepairTicketController::class, 'index'])->name('repair-tickets.index');
    Route::get('/brands', [BrandController::class, 'index'])->name('brands.index');
    Route::get('/device-types', [DeviceTypeController::class, 'index'])->name('device-types.index');
    Route::get('/device-attributes', [SpecAttributeController::class, 'index'])->name('device-attributes.index');


    Route::get('/device-models', [DeviceModelController::class, 'index'])->name('device-models.index');
    Route::get('/device-models/{device_model}/attributes', [DeviceModelController::class, 'getAttributesWithOptions'])->name('device-models.index');


    Route::post('repair-request/create', [RepairRequestController::class, 'store'])->name('repair-request.store');
});
    Route::post('repair-requests/generate-ai-reply', [RepairRequestController::class, 'ask'])->name('repair-request.ai-replay');



require __DIR__ . '/api/auth-api.php';
