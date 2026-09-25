
<?php

use App\Http\Controllers\Customer\Repair\RepairTrackingController;
use App\Http\Controllers\Web\Repair\RepairTicketController;
use Illuminate\Support\Facades\Route;


Route::get(
    "/repair-tracking/{ticket_number}/ticket",
    [RepairTrackingController::class, 'show']
)
    ->name('customer.repair.track');
Route::get(
    "/repair-tickets/{repair_ticket}/pdf",
    [RepairTicketController::class, 'download']
)
    ->middleware('signed')
    ->name('repair-tickets.download');
