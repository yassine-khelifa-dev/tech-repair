<?php

namespace App\Enums;

enum SpecUnit:string
{
    case NOP = 'None';
    case GB = 'GB';
    case TB = 'TB';
    case WATT = 'W';
    case VOLT = 'V';
    case MAH = 'mAh';
    case PERCENT = '%';
    case INCH = 'inch';
}
