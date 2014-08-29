<?php

namespace Core\APL\Modules;

use Core\APL\Actions,
    Core\APL\Template,
    PersonGroup,
    PersonGroupLang,
    PersonGroupPostModel,
    PersonModel,
    PersonRelModel,
    PersonLangModel,
    PageView;

class Person extends \Core\APL\ExtensionController {

    protected $module_name = 'person';
    protected $layout;

    public function __construct() {
        parent::__construct();

        $this->loadClass(array('PersonModel', 'PersonLangModel'));

        Template::registerViewMethod('page', 'group_with_persons', '', array($this, 'group_list'), true);
    }

    public function group_list($data) {
        $groups = PersonGroup::join(PersonGroupPostModel::getTableName(), PersonGroupPostModel::getField("group_id"), '=', PersonGroup::getField("id"))
                ->join(PersonGroupLang::getTableName(), PersonGroupLang::getField("group_id"), '=', PersonGroup::getField('id'))
                ->where(PersonGroupLang::getField("lang_id"), \Core\APL\Language::getId())
                ->where(PersonGroupPostModel::getField("post_id"), $data['page']->id)
                ->select(PersonGroupLang::getField('name'), PersonGroupLang::getField('description'), PersonGroup::getField("id"))
                ->get();
        if ($groups) {
            foreach ($groups as &$group) {
                $group['persons'] = PersonModel::join(PersonLangModel::getTableName(), PersonLangModel::getField("person_id"), '=', PersonModel::getField("id"))
                        ->join(PersonRelModel::getTableName(), PersonRelModel::getField("person_id"), '=', PersonModel::getField("id"))
                        ->where(PersonLangModel::getField("lang_id"), \Core\APL\Language::getId())
                        ->where(PersonRelModel::getField("group_id"), $group->id)
                        ->get();
            }

            $data["page"]->text = Template::moduleView($this->module_name, "views.person_groups", array('groups' => $groups));
        }

        return PageView::defaultView($data);
    }

}
