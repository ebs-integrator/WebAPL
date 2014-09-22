<?php

class CalendarLangModel extends Eloquent {

    use EloquentTrait;
    
    protected $table = 'apl_calendar_item_lang';
    public static $ftable = 'apl_calendar_item_lang';
    public $timestamps = false;

}
