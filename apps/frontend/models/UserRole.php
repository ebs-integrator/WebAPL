<?php

class UserRole extends Eloquent {

    use EloquentTrait;
    
    protected $table = 'apl_user_role';
    public $timestamps = false;
}