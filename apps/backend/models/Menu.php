<?php 
 
 /**
  * 
  * CMS Platform WebAPL 1.0 is a free open source software for creating and managing
  * a web site for Local Public Administration institutions. The platform was
  * developed at the initiative and on a concept of USAID Local Government Support
  * Project in Moldova (LGSP) by the Enterprise Business Solutions Srl (www.ebs.md).
  * The opinions expressed on the website belong to their authors and do not
  * necessarily reflect the views of the United States Agency for International
  * Development (USAID) or the US Government.
  * 
  * This program is free software: you can redistribute it and/or modify it under
  * the terms of the GNU General Public License as published by the Free Software
  * Foundation, either version 3 of the License, or any later version.
  * This program is distributed in the hope that it will be useful, but WITHOUT ANY
  * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A
  * PARTICULAR PURPOSE. See the GNU General Public License for more details.
  * 
  * You should have received a copy of the GNU General Public License along with
  * this program. If not, you can read the copy of GNU General Public License in
  * English here: <http://www.gnu.org/licenses/>.
  * 
  * For more details about CMS WebAPL 1.0 please contact Enterprise Business
  * Solutions SRL, Republic of Moldova, MD 2001, Ion Inculet 33 Street or send an
  * email to office@ebs.md 
  * 
  **/
 
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
                ->select(MenuItem::$ftable . ".id", MenuItemLang::$ftable . ".title", MenuItemLang::$ftable . ".href")
                ->where('parent', $parent)
                ->join(MenuItemLang::$ftable, MenuItemLang::$ftable . '.menu_item_id', '=', MenuItem::$ftable . '.id')
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
