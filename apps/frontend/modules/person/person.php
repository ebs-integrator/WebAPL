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
    PersonAudienceModel,
    Shortcodes,
    Validator,
    Input,
    SimpleCapcha,
    PageView;

class Person extends \Core\APL\ExtensionController {

    protected $module_name = 'person';
    protected $layout;

    public function __construct() {
        parent::__construct();

        $this->loadClass(array('PersonModel', 'PersonLangModel', 'PersonAudienceModel'));

        Template::registerViewMethod('page', 'group_with_persons', '', array($this, 'group_list'), true);
        Template::registerViewMethod('page', 'persons_with_photo', 'Persoane cu foto', array($this, 'photo_persons'), true);
        Template::registerViewMethod('page', 'persons_big', 'Persoane cu foto (viceprimari)', array($this, 'vicemayor'), true);
        Template::registerViewMethod('page', 'persons_mayor', 'Persoana cu foto (primar)', array($this, 'mayor'), true);
        Template::registerViewMethod('page', 'persons_secretar', 'Persoana cu foto (secretar)', array($this, 'secretar'), true);
        Template::registerViewMethod('page', 'city_councilors', 'Consilieri locali', array($this, 'councilors'), true);

        Shortcodes::register('person_subscribe', array($this, 'subscribe'));

        Actions::post('person/subscribe_to_audience', array($this, 'subscribe_to_audience'));
    }

    public function group_list($data) {
        $groups = PersonModel::getPostPersonGroups($data['page']->id);
        if ($groups) {
            $data["page"]->text = Template::moduleView($this->module_name, "views.person_groups", array('groups' => $groups));
        }

        return PageView::defaultView($data);
    }
    
    public function councilors($data) {
        $groups = PersonModel::getPostPersonGroups($data['page']->id);
        if ($groups) {
            $data["page"]->text = Template::moduleView($this->module_name, "views.person_councilors", array('groups' => $groups));
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

    public function secretar($data) {
        $groups = PersonModel::getPostPersonGroups($data['page']->id);
        if ($groups) {
            $data["page"]->text = Template::moduleView($this->module_name, "views.person_secretar", array(
                        'groups' => $groups
            ));
        }

        return PageView::defaultView($data);
    }

    public function subscribe() {
        $data = array(
            'persons' => PersonModel::join(PersonLangModel::getTableName(), PersonLangModel::getField('person_id'), '=', PersonModel::getField('id'))
                    ->select(PersonModel::getField('id'), PersonLangModel::getField('first_name'), PersonLangModel::getField('last_name'))
                    ->orderBy(PersonLangModel::getField('first_name'))
                    ->where(PersonModel::getField('for_audience'), 1)
                    ->where(PersonLangModel::getField('lang_id'), \Core\APL\Language::getId())
                    ->get()
        );
        return Template::moduleView($this->module_name, 'views.block_subscribe', $data);
    }

    public function subscribe_to_audience() {
        $validator = Validator::make(array(
                    'person_id' => Input::get('person_id'),
                    'email' => Input::get('email'),
                    'name' => Input::get('name'),
                    'phone' => Input::get('phone'),
                    'capcha' => SimpleCapcha::valid('person_subscribe', Input::get('capcha')) ? 1 : null
                        ), array(
                    'person_id' => 'required',
                    'name' => 'required',
                    'email' => 'email|required',
                    'phone' => 'required',
                    'capcha' => 'required'
        ));

        $return = array(
            'message' => '',
            'error' => 0
        );

        if ($validator->fails()) {
            $return['message'] = implode(' ', $validator->messages()->all('<p>:message</p>'));
            $return['error'] = 1;
        } else {
            SimpleCapcha::destroy('person_subscribe');

            $audience = new PersonAudienceModel;
            $audience->person_id = Input::get('person_id');
            $audience->name = Input::get('name');
            $audience->email = Input::get('email');
            $audience->phone = Input::get('phone');
            $audience->save();
        }

        return $return;
    }

}
