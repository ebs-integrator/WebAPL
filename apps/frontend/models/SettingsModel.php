<?php

class SettingsModel extends Eloquent {

    use EloquentTrait;

    protected $table = 'apl_setting';
    protected $primaryKey = 'key';
    public $timestamps = false;
    private $settings = array();

    public static function getAll() {
        if (self::$settings) {
            return self::$settings;
        }

        $list = SettingsModel::all();

        $return = array();

        foreach ($list as $item) {
            $return[$item->key] = $item->value;
        }

        self::$settings = $return;

        return $return;
    }

    public static function one($key) {
        $list = self::getAll();
        return isset($list[$key]) ? $list[$key] : false;
    }

    public static function put($key, $value) {
        $set = SettingsModel::where('key', $key)->first();
        if ($set) {
            SettingsModel::where('key', $key)->update(array(
                'value' => $value
            ));
        } else {
            SettingsModel::insert(array(
                'value' => $value,
                'key' => $key
            ));
        }
    }

}
