<?php


namespace App\Helpers;


class StringHelper
{
    public static function toLower($string) {
        if (is_string($string)){
            return strtolower($string);
        } else {
            return false;
        }
    }

    public static function toUpper($string) {
        if (is_string($string)){
            return strtoupper($string);
        } else {
            return false;
        }
    }
}