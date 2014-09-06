<?php

class PersonModel extends Eloquent {

    use EloquentTrait;

    protected $table = 'apl_person';
    public static $ftable = 'apl_person'; // public table name
    public $timestamps = false;

    public function langs() {
        return $this->hasMany('PersonLangModel', 'person_id', 'id');
    }

    public static function getPostPersonGroups($post_id) {
        $groups = PersonGroup::join(PersonGroupPostModel::getTableName(), PersonGroupPostModel::getField("group_id"), '=', PersonGroup::getField("id"))
                ->join(PersonGroupLang::getTableName(), PersonGroupLang::getField("group_id"), '=', PersonGroup::getField('id'))
                ->where(PersonGroupLang::getField("lang_id"), \Core\APL\Language::getId())
                ->where(PersonGroupPostModel::getField("post_id"), $post_id)
                ->select(PersonGroupLang::getField('name'), PersonGroupLang::getField('description'), PersonGroup::getField("id"))
                ->get();
        if ($groups) {
            foreach ($groups as &$group) {
                $persons = PersonModel::join(PersonLangModel::getTableName(), PersonLangModel::getField("person_id"), '=', PersonModel::getField("id"))
                        ->join(PersonRelModel::getTableName(), PersonRelModel::getField("person_id"), '=', PersonModel::getField("id"))
                        ->leftJoin(Files::getTableName(), Files::getField("module_id"), '=', PersonModel::getField("id"))
                        ->where(PersonLangModel::getField("lang_id"), \Core\APL\Language::getId())
                        ->where(PersonRelModel::getField("group_id"), $group->id)
                        ->where(Files::getField("module_name"), 'person')
                        ->get();

                $group['persons'] = $persons;
            }
        }

        return $groups;
    }

}
