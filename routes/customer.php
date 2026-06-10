
<?php

use App\Http\Controllers\Customer\Repair\RepairTrackingController;
use Illuminate\Support\Facades\Route;


Route::get("/repair-tracking/{ticket_number}/ticket", [RepairTrackingController::class, 'show'])->name('customer.repair.track');
