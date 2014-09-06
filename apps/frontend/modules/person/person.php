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
        Template::registerViewMethod('page', 'persons_with_photo', 'Persoane cu foto', array($this, 'photo_persons'), true);
        Template::registerViewMethod('page', 'persons_big', 'Persoane cu foto (viceprimari)', array($this, 'vicemayor'), true);
        Template::registerViewMethod('page', 'persons_mayor', 'Persoana cu foto (primar)', array($this, 'mayor'), true);
    }

    public function group_list($data) {
        $groups = PersonModel::getPostPersonGroups($data['page']->id);
        if ($groups) {
            $data["page"]->text = Template::moduleView($this->module_name, "views.person_groups", array('groups' => $groups));
        }

        return PageView::defaultView($data);
    }
    
    public function photo_persons($data) {
        $groups = PersonModel::getPostPersonGroups($data['page']->id);
        if ($groups) {
            $data["page"]->text = Template::moduleView($this->module_name, "views.person_photos", array('groups' => $groups));
        }

        return PageView::defaultView($data);
    }
    
    public function vicemayor($data) {
        $groups = PersonModel::getPostPersonGroups($data['page']->id);
        if ($groups) {
            $data["page"]->text = Template::moduleView($this->module_name, "views.person_mayors", array('groups' => $groups));
        }

        return PageView::defaultView($data);
    }
    
    public function mayor($data) {
        $groups = PersonModel::getPostPersonGroups($data['page']->id);
        if ($groups) {
            $data["page"]->text = Template::moduleView($this->module_name, "views.person_mayor", array('groups' => $groups));
        }

        return PageView::defaultView($data);
    }
}
