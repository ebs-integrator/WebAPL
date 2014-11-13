<?php

/**
 * 
 * CMS WebAPL 1.0. Platform is a free open source software for creating an managing
 * their full with CMS integrated CMS system
 * 
 * Copyright (C) 2014 Enterprise Business Solutions SRL
 * 
 * This program is free software: you can redistribute it and/or modify it under
 * the terms of the GNU General Public License as published by the Free Software
 * Foundation, either version 3 of the License, or any later version.
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A
 * PARTICULAR PURPOSE. See the GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License along with
 * this program.  If not, see <http://www.gnu.org/licenses/>.
 * You can read the copy of GNU General Public License in english here 
 * 
 * For more details about CMS WebAPL 1.0 please contact Enterprise Business
 * Solutions SRL, Republic of Moldova, MD 2001, Ion Inculet 33 Street or send an
 * email to office@ebs.md 
 * 
 */
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
