<?php

class PersonLangModel extends Eloquent {

    use EloquentTrait;
    
    
    protected $table = 'apl_person_lang';
    public static $ftable = 'apl_person_lang'; // public table name
    public $timestamps = false;

}
