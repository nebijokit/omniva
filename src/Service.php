<?php

namespace Omniva;

use MyCLabs\Enum\Enum;

/**
 * @method static Service TERMINAL()
 * @method static Service COURIER()
 * @method static Service COURIER_LT_LV()
 * @method static Service POST_OFFICE()
 */
class Service extends Enum
{
    const SMS = 'ST';
    const EMAIL = 'SF';
    const COD = 'BP';
    const TERMINAL = 'PP';
    const POST_OFFICE = 'CD';
    const COURIER = 'QP';
    const COURIER_LT_LV = 'QH';
}
