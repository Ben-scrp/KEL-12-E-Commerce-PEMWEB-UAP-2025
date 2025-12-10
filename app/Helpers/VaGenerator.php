<?php

namespace App\Helpers;

class VaGenerator
{
    public static function generate()
    {
        // Generate random 16 digit number
        return '8800' . rand(100000000000, 999999999999);
    }
}
