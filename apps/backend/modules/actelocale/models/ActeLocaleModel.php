<?php

class ActeLocaleModel extends Eloquent {

    use EloquentTrait;

    protected $table = 'apl_acte';
    public $timestamps = false;
    public static $filesDir = "actelocale";
    public static $filesModule = "actelocale";

    public static function createEmpty() {
        $item = new ActeLocaleModel;
        $item->save();

        return $item->id;
    }

    public static function deleteItem($id) {
        $item = ActeLocaleModel::find($id);
        if ($item) {
            $item->delete();
            Files::dropMultiple(ActeLocaleModel::$filesModule, $id);
        }
    }

}
