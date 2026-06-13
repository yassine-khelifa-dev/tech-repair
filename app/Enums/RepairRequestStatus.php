<?php

namespace App\Enums;

enum RepairRequestStatus:string
{
    case pending = 'pending';
    case approved = 'approved';
    case rejected = 'rejected';

}



