<?php

class PollQuestionModel extends Eloquent {

    use EloquentTrait;
    
    protected $table = 'apl_poll_question';
    public static $ftable = 'apl_poll_question'; // public table name
    public $timestamps = false;

}
