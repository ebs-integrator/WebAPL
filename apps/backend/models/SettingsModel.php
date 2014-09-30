<?php

class SettingsModel extends Eloquent {

    use EloquentTrait;
    
    protected $table = 'apl_setting';
    protected $primaryKey = 'key';
    public $timestamps = false;
    
    public static function getAll() {
        $list = SettingsModel::all();
        
        $return = array();
        
        foreach ($list as $item) {
            $return[$item->key] = $item->value;
        }
        
        return $return;
    }
}