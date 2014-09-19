<?php

class CalendarModel extends Eloquent {

    use EloquentTrait;
    
    protected $table = 'apl_calendar_item';
    public static $ftable = 'apl_calendar_item';
    public $timestamps = false;

}
