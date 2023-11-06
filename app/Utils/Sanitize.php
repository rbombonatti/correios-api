<?php

namespace App\Utils;


class Sanitize
{

    public static function clearString($original)
    {
        $sanitized = htmlspecialchars(strip_tags($original));
        $sanitized = str_replace("'", "", $sanitized);

        return $sanitized;
    }
}
