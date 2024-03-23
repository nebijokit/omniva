<?php

declare(strict_types=1);

namespace Omniva;

enum Service : string
{
    case SMS = 'ST';
    case EMAIL = 'SF';
    case COD = 'BP';
    case TERMINAL = 'PP';
    case POST_OFFICE = 'CD';
    case COURIER = 'QP';
    case COURIER_LT_LV = 'QH';
}
