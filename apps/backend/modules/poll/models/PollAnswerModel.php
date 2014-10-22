<?php

class PollAnswerModel extends Eloquent {

    use EloquentTrait;
    
    protected $table = 'apl_poll_answer';
    public static $ftable = 'apl_poll_answer'; // public table name
    public $timestamps = false;

}
