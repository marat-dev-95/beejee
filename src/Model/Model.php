<?php
namespace App\Model;

abstract class Model
{
    protected static $table;

    public static function getTableName() {
        return static::$table;
    }

}