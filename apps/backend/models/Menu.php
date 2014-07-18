<?php

class Menu extends Eloquent {

    protected $table = 'apl_menu';
    public static $ftable = 'apl_menu';
    public $timestamps = false;

    public static function insertArray($array) {
        DB::table(self::$ftable)->insert($array);
    }

    public static function updateArray($array, $where) {
        DB::table(self::$ftable)
                ->where('id', $where)
                ->update($array);
    }

    public function menuitems() {
        return $this->hasMany('MenuItem', 'menu_id', 'id');
    }

    public static function treeItems($menuId, $parent = 0) {
        $items = MenuItem::where('menu_id', $menuId)
                ->where('parent', $parent)
                ->join(MenuItemLang::$ftable, MenuItemLang::$ftable.'.menu_item_id', '=', MenuItem::$ftable.'.id')
                ->where('lang_id', Language::getId())
                ->orderBy('ord')
                ->get();
        foreach ($items as &$item) {
            $item['list'] = Menu::treeItems($menuId, $item->id);
        }
        return $items;
    }
    
    public static function updateTree($tree, $parent = 0) {
        $ord = 0;
        foreach ($tree as $item) {
            $ord++;
            $itm = MenuItem::find($item['id']);
            $itm->parent = $parent;
            $itm->ord = $ord;
            $itm->save();
            
            if (isset($item['children'])) {
                Menu::updateTree($item['children'], $item['id']);
            }
        }
    }
    
    public static function drop($id) {
        $menu = Menu::find($id);
        foreach (MenuItem::where('menu_id', $id)->get() as &$item) {
            $item->menuitems()->delete();
            //MenuItemLang::where('menu_item_id', $item->id)->delete();
            $item->delete();
        }
        $menu->delete();
    }

}
