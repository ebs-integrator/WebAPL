<?php

class LogModel extends Eloquent {

    use EloquentTrait;
    
    protected $table = 'apl_logs';
    public $timestamps = false;
    
}