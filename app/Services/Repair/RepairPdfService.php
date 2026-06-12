<?php

namespace App\Services\Repair;

use App\Models\RepairTicket;
use Barryvdh\DomPDF\Facade\Pdf;
use Symfony\Component\HttpFoundation\Response;

class RepairPdfService
{
    public function downloadDepositReceipt(RepairTicket $ticket): Response
    {
        $fileName = 'repair-receipt-' . $ticket->ticket_number . '.pdf';
        $pdf        = Pdf::loadView(
            'pdfs.repair.repair-ticket',
            ['ticket' => $ticket]
        )->setPaper('a4');
        return $pdf->download($fileName);
    }
}
