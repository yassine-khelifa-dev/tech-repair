<?php

namespace App\Enums;

enum SpecInputType: string
{
    case SELECT = 'select';

    // Planned input types. Phone specifications are currently managed as controlled select options.
    // case TEXT = 'text';
    // case TEXTAREA = 'textarea';
    // case NUMBER = 'number';
    // case BOOLEAN = 'boolean';
    // Multiselect is intentionally disabled until the repair request flow supports multiple values per attribute.
    // case MULTISELECT = 'multiselect';
}
