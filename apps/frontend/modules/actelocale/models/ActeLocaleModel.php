<?php

class ActeLocaleModel extends Eloquent {

    use EloquentTrait;

    protected $table = 'apl_acte';
    public $timestamps = false;
    public static $filesDir = "actelocale";
    public static $filesModule = "actelocale";

    public static function getYears() {
        return ActeLocaleModel::distinct()
                        ->orderBy(ActeLocaleModel::getField('date_upload'), 'desc')
                        ->select(DB::raw("YEAR(" . ActeLocaleModel::getField('date_upload') . ") as year"))
                        ->get();
    }

    public static function prepare() {
        return ActeLocaleModel::join(Files::getTableName(), Files::getField('module_id'), '=', ActeLocaleModel::getField('id'))
                        ->where(Files::getField('module_name'), ActeLocaleModel::$filesModule)
                        ->select(ActeLocaleModel::getField("*"), Files::getField('path'), DB::raw("MONTH(" . ActeLocaleModel::getField('date_upload') . ") as date_month"))
                        ->orderBy(ActeLocaleModel::getField('date_upload'), 'asc');
    }

    public static function extract($year) {
        $list = ActeLocaleModel::prepare()
                ->where(DB::raw("YEAR(" . ActeLocaleModel::getField('date_upload') . ")"), intval($year))
                ->get();

        $groups = [];

        foreach ($list as $item) {
            if (isset($groups[$item->date_month])) {
                $groups[$item->date_month][] = $item;
            } else {
                $groups[$item->date_month] = [$item];
            }
        }

        return $groups;
    }
    
    public static function last($year) {
        return ActeLocaleModel::prepare()
                ->where(ActeLocaleModel::getField('date_upload'), '<=', DB::raw("CURRENT_TIMESTAMP"))
                ->orderBy(ActeLocaleModel::getField('date_upload'), 'desc')
                ->first();
    }
    
}
