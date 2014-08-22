<?php

class PollModel extends Eloquent {

    protected $table = 'apl_poll';
    public static $ftable = 'apl_poll'; // public table name
    public $timestamps = false;

    public function langs() {
        return $this->hasMany('PollQuestionModel', 'poll_id', 'id');
    }

}
