<?php

namespace Core\APL\Modules;

use Core\APL\Actions,
    Core\APL\Template,
    Input,
    jQgrid,
    Language,
    PersonModel,
    PersonLangModel,
    Exception;

class Person extends \Core\APL\ExtensionController {

    protected $module_name = 'person';
    protected $layout;

    public function __construct() {
        parent::__construct();

        $this->loadClass(array('PersonModel', 'PersonLangModel'));

        // Set settings page
        Actions::get('person/settings', array('before' => 'auth', array($this, 'settings')));

        // Set others routes
        Actions::get('person/list', array('before' => 'auth', array($this, 'list_persons')));
        Actions::post('person/getlist', array('before' => 'auth', array($this, 'getlist')));

        Actions::get('person/form', array('before' => 'auth', array($this, 'form')));
        Actions::get('person/form/{id}', array('before' => 'auth', array($this, 'form')));
        Actions::post('person/save', array('before' => 'auth', array($this, 'save')));
        Actions::post('person/save_lang', array('before' => 'auth', array($this, 'save_lang')));
        Actions::post('person/save_dynamic_fields', array('before' => 'auth', array($this, 'save_dynamic_fields')));


        // Register new action
        Actions::register('construct_left_menu', array($this, 'left_menu_item'));

        // Set layout
        $this->layout = Template::mainLayout();
    }

    /**
     * Settings page for person module
     * @return layout
     */
    public function settings() {
        $this->layout->content = Template::moduleView($this->module_name, 'views.settings');

        return $this->layout;
    }

    /**
     * Action for left menu
     */
    public function left_menu_item() {
        echo Template::moduleView($this->module_name, 'views.person-left-menu');
    }

    /**
     * jqgrid view with persons list
     * @return layout
     */
    public function list_persons() {
        $this->layout->content = Template::moduleView($this->module_name, 'views.list');

        return $this->layout;
    }

    /**
     * get list of persons for jqgrid
     * @return json
     */
    public function getlist() {
        $jqgrid = new jQgrid('apl_person');
        echo $jqgrid->populate(function ($start, $limit) {
                    return PersonLangModel::select('person_id', 'first_name', 'last_name')
                                    ->where('lang_id', Language::getId())
                                    ->skip($start)
                                    ->take($limit)
                                    ->get();
                });
    }

    /**
     * Edit / create person
     * @param person id $id
     * @return layout
     */
    public function form($id = 0) {
        $data = array(
            'person' => PersonModel::find($id),
            'person_lang' => array(),
            'module' => $this->module_name
        );

        if ($data['person']) {
            $personLangs = PersonModel::find($id)->langs()->get();
            foreach ($personLangs as $personLang) {
                $data['person_lang'][$personLang->lang_id] = $personLang;
            }
        }

        $this->layout->content = Template::moduleView($this->module_name, 'views.form', $data);
        return $this->layout;
    }

    /**
     * Save changes
     * @return array/json
     */
    public function save() {
        $id = Input::get('id');


        if ($id) {
            // if the person exist, find
            $person = PersonModel::find($id);
        } else {
            // if the person does not exist, create new
            $person = new PersonModel;
        }
        $person->phone = Input::get('phone');
        $person->email = Input::get('email');
        $person->date_birth = Input::get('date_birth');
        $person->save();

        if ($id) {
            return array(
                'error' => 0
            );
        } else {
            // if person has been created, refresh page
            return array(
                'redirect_to' => url('person/form/' . $person->id)
            );
        }
    }

    /**
     * Save language changes
     * @return array/json
     */
    public function save_lang() {
        $person_id = Input::get('person_id');
        $person_lang_id = Input::get('person_lang_id');
        $new_person_id = 0;

        if ($person_lang_id) {
            // if the person-lang exist, find
            $person_lang = PersonLangModel::find($person_lang_id);
        } else {
            if (!$person_id) {
                // if the person does not exist, create empty person record
                $person = new PersonModel;
                $person->save();
                $new_person_id = $person->id;
            }

            // if the person-lang does not exist, create new
            $person_lang = new PersonLangModel;
        }

        $person_lang->person_id = $person_id ? $person_id : $new_person_id;
        $person_lang->lang_id = Input::get('lang_id');
        $person_lang->first_name = Input::get('first_name');
        $person_lang->last_name = Input::get('last_name');
        $person_lang->function = Input::get('function');
        $person_lang->civil_state = Input::get('civil_state');
        $person_lang->studies = Input::get('studies');
        $person_lang->activity = Input::get('activity');
        $person_lang->motto = Input::get('motto');
        $person_lang->save();

        if ($new_person_id) {
            // if person has been created, refresh page
            return array(
                'redirect_to' => url('person/form/' . $new_person_id)
            );
        }
    }

    /**
     * Save dynamic field for person
     */
    public function save_dynamic_fields() {
        $person_id = Input::get('person_id');
        $fields = Input::get('field');

        $pattern = array('name', 'lang_id', 'value');
        $rows = array();

        $i = 0;
        $ri = 0;
        $fcount = count($fields);
        while ($i < $fcount) {
            foreach ($pattern as $point) {
                $rows[$ri][$point] = $fields[$i][$point];
                $i++;
            }
            $ri++;
        }

        unset($rows[count($rows) - 1]);

        $person = PersonModel::find($person_id);
        if ($person) {
            $person->dynamic_fields = serialize($rows);
            $person->save();
        } else {
            throw new Exception("Undefined person, BAG: rows-" . serialize($rows));
        }
    }

}