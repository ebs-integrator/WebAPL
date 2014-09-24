<?php

class Role extends Eloquent {

    use EloquentTrait;
    
    protected $table = 'apl_role';
    public $timestamps = false;
}