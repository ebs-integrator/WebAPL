<?php

class MenuItem extends Eloquent {

    protected $table = 'apl_menu_item';
    public static $ftable = 'apl_menu_item';
    public $timestamps = false;

    public function menu() {
        return $this->belongsTo('Menu');
    }

    public function menuitemslang() {
        return $this->hasMany('MenuItemLang', 'menu_item_id', 'id');
    }

    public static function insertLinkItem($id, $langList) {
        $item = new MenuItem;
        $item->menu_id = $id;
        $item->enabled = 1;
        $item->parent = 0;
        $item->save();

        foreach ($langList as $lang_id => $data) {
            $itemLang = new MenuItemLang;
            $itemLang->menu_item_id = $item->id;
            $itemLang->lang_id = $lang_id;
            $itemLang->title = $data['name'];
            $itemLang->href = $data['link'];
            $itemLang->save();
        }
    }

    public static function deleteNode($id) {
        $node = MenuItem::find($id);

        if ($node) {
            $children = MenuItem::where('parent', $id)->get();

            foreach ($children as $child) {
                $child->parent = $node->parent;
                $child->save();
            }
            
            $node->delete();
        }
    }
    
}
