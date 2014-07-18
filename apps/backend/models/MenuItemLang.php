<?php

class MenuItemLang extends Eloquent {

    protected $table = 'apl_menu_item_lang';
    public static $ftable = 'apl_menu_item_lang';
    public $timestamps = false;

    public function menuitem() {
        return $this->belongsTo('MenuItem');
    }

    public static function updateNode($items) {
        foreach ($items as $id => $item) {
            $node = MenuItemLang::find($id);
            $node->title = $item['title'];
            $node->href = $item['href'];
            $node->save();
        }
    }
    
}
