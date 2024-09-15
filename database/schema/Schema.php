<?php

namespace sprint\database\schema;

use \sprint\database\schema\BluePrintSchema;

class Schema
{    
    public static function run(String $tableName, callable $callback)
    {
        $bluePrintSchema = new BluePrintSchema();
        
        $bluePrintSchema->setTable($tableName);
        
        call_user_func($callback, $bluePrintSchema);
    }
}