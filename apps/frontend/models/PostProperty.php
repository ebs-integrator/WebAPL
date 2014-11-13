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
class PostProperty extends Eloquent {

    use EloquentTrait;

    protected $table = 'apl_post_property';
    public $timestamps = false;

    public static function prepare() {
        return Post::prepareQuery(1)
                        ->join(PostPropertyRel::getTableName(), Post::getField('id'), '=', PostPropertyRel::getField('post_id'))
                        ->join(PostProperty::getTableName(), PostProperty::getField('id'), '=', PostPropertyRel::getField('post_property_id'))
                        ->orderBy(Post::getField('ord_num'), 'asc');
    }

    public static function postsWithProperty($property, $take = 0) {
        $instance = PostProperty::prepare()
                ->where(PostLang::getField('enabled'), 1)
                ->where(PostProperty::getField('key'), $property);

        if ($take) {
            $instance = $instance->take($take);
        }

        return $instance->remember(SettingsModel::one('cachelife'))->get();
    }

    public static function postWithProperty($property, $with_url = false) {
        $row = PostProperty::prepare()
                ->where(PostLang::getField('enabled'), 1)
                ->where(PostProperty::getField('key'), $property)
                ->remember(SettingsModel::one('cachelife'))
                ->first();

        if ($row && $with_url) {
            $row['url'] = Post::getFullURI($row->id);
        }

        return $row ? $row : false;
    }

    public static $properties = array();

    public static function getPostProperties($id) {
        if (isset(static::$properties[$id])) {
            return static::$properties[$id];
        }

        $list = PostPropertyRel::join(PostProperty::getTableName(), PostProperty::getField('id'), '=', PostPropertyRel::getField('post_property_id'))
                ->where(PostPropertyRel::getField('post_id'), $id)
                ->remember(SettingsModel::one('cachelife'))
                ->get();

        $names = array();

        foreach ($list as $item) {
            $names[] = $item->key;
        }

        static::$properties[$id] = $names;
        return $names;
    }

}
