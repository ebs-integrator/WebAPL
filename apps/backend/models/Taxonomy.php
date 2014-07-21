<?php

class Taxonomy extends Eloquent {

    protected $table = 'apl_taxonomy';
    public $timestamps = false;

    public static function get($name) {
        return Taxonomy::where('name', $name)->first();
    }

}