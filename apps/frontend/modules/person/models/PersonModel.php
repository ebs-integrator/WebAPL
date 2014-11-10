<?php

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
