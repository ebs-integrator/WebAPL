<?php

class PersonModel extends Eloquent {

    use EloquentTrait;
    
    protected $table = 'apl_person';
    public static $ftable = 'apl_person'; // public table name
    public $timestamps = false;
    
    public function langs() {
        return $this->hasMany('PersonLangModel', 'person_id', 'id');
    }

}