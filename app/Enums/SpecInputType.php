<?php

namespace App\Enums;

enum SpecInputType: string
{
    case TEXT = 'text';
    case TEXTAREA = 'textarea';
    case NUMBER = 'number';
    case SELECT = 'select';
    case MULTISELECT = 'multiselect';
    case BOOLEAN = 'boolean';
}
