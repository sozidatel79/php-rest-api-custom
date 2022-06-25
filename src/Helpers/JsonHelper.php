<?php


namespace App\Helpers;


class JsonHelper
{
    public static function jsonToArray($json){
        if (is_string($json)){
            return json_decode($json, true);
        } else {
            return false;
        }
    }

    public static function arrayToJson($array){
        if (is_array($array)){
            return json_encode($array);
        } else {
            return false;
        }
    }

}