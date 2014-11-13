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
class PersonModel extends Eloquent {

    use EloquentTrait;

    protected $table = 'apl_person';
    public static $ftable = 'apl_person'; // public table name
    public $timestamps = false;

    public function langs() {
        return $this->hasMany('PersonLangModel', 'person_id', 'id');
    }

    protected static function personPrepare() {
        return PersonModel::join(PersonLangModel::getTableName(), PersonLangModel::getField("person_id"), '=', PersonModel::getField("id"))
                        ->join(PersonRelModel::getTableName(), PersonRelModel::getField("person_id"), '=', PersonModel::getField("id"))
                        ->leftJoin(Files::getTableName(), function($join) {
                            $join->on(Files::getField("module_id"), '=', PersonModel::getField("id"));
                            $join->on(Files::getField("module_name"), '=', DB::raw("'person'"));
                        })
                        ->where(PersonLangModel::getField("lang_id"), \WebAPL\Language::getId());
    }

    public static function getPostPersonGroups($post_id) {
        $groups = PersonGroup::join(PersonGroupPostModel::getTableName(), PersonGroupPostModel::getField("group_id"), '=', PersonGroup::getField("id"))
                ->join(PersonGroupLang::getTableName(), PersonGroupLang::getField("group_id"), '=', PersonGroup::getField('id'))
                ->where(PersonGroupLang::getField("lang_id"), \WebAPL\Language::getId())
                ->where(PersonGroupPostModel::getField("post_id"), $post_id)
                ->select(PersonGroupLang::getField('name'), PersonGroupLang::getField('description'), PersonGroup::getField("id"))
                ->get();
        if ($groups) {
            foreach ($groups as &$group) {
                $persons = PersonModel::personPrepare()
                        ->where(PersonRelModel::getField("group_id"), $group->id)
                        ->get();

                foreach ($persons as &$person) {
                    if ($person->feed_id) {
                        $person['posts'] = \Post::postsFeed($person->feed_id);
                    } else {
                        $person['posts'] = array();
                    }
                }

                $group['persons'] = $persons;
            }
        }

        return $groups;
    }

    public static function getPerson($id) {
        $person = PersonModel::personPrepare()
                ->where(PersonModel::getField('id'), $id)
                ->first();
        
        if ($person->feed_id) {
            $person['posts'] = \Post::postsFeed($person->feed_id);
        } else {
            $person['posts'] = array();
        }
        
        return $person;
    }

}
