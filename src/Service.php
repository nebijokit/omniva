<?php

namespace Omniva;

use MyCLabs\Enum\Enum;

class Service extends Enum
{
    private const SMS = 'ST';
    private const EMAIL = 'SF';
    private const COD = 'BP';
    private const TERMINAL = 'PP';
    private const COURIER = 'QP';
    private const COURIER_LT_LV = 'QH';
}
