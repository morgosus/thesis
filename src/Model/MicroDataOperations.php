<?php

namespace App\Model;


class MicroDataOperations
{

    static $start;
    
    public static function setStart($startTime) {
        self::$start = $startTime;
    }
    
    public static function getDifference() {
        
        return '(' . round((microtime(true) - self::$start), 4) . 's)';
    }
}