<?php

trait EloquentTrait {

    public static function getTableName() {
        return ((new self)->getTable());
    }
    
    public static function getField($name) {
        return self::getTableName().".".$name;
    }

}
