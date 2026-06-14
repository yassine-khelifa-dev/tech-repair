<?php

namespace App\Enums;

enum RepairStatus:string
{
    case APPROVED = 'approved';
    case RECEIVED = 'received';
    case DIAGNOSIS = 'diagnosis';
    case WAITING_PARTS = 'waiting_parts';
    case IN_PROGRESS = 'in_progress';
    case READY = 'ready';
    case DELIVERED = 'delivered';
    case CANCELLED = 'cancelled';
}
