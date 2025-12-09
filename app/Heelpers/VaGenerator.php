<?php

namespace App\Helpers;

class VaGenerator
{
    public static function generate()
    {
        return '888' . time() . rand(100, 999);
    }
}
