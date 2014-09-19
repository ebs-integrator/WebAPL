<?php

class CalendarPostModel extends Eloquent {

    use EloquentTrait;
    
    protected $table = 'apl_calendar_post';
    public static $ftable = 'apl_calendar_post';
    public $timestamps = false;

}
