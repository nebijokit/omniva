<?php

namespace Omniva;

use MyCLabs\Enum\Enum;

/**
 * @method Service TERMINAL()
 * @method Service COURIER()
 * @method Service COURIER_LT_LV()
 * @method Service POST_OFFICE()
 */
class Service extends Enum
{
    private const SMS = 'ST';
    private const EMAIL = 'SF';
    private const COD = 'BP';
    private const TERMINAL = 'PP';
    private const POST_OFFICE = 'CD';
    private const COURIER = 'QP';
    private const COURIER_LT_LV = 'QH';
}
