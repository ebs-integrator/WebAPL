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
 

namespace WebAPL\Modules;

use WebAPL\Actions,
    WebAPL\Template,
    Input,
    jQgrid,
    Language,
    PersonModel,
    PersonLangModel,
    PersonGroup,
    PersonGroupLang,
    PersonGroupPostModel,
    PersonRelModel,
    DB,
    Redirect,
    PersonAudienceModel,
    Route,
    User,
    Event,
    Exception;

class Person extends \WebAPL\ExtensionController {

    protected $module_name = 'person';
    protected $layout;

    public function __construct() {
        parent::__construct();

        $this->loadClass(array(
            'PersonModel',
            'PersonLangModel',
            'PersonGroupPostModel',
            'PersonGroupLang',
            'PersonGroup'
        ));

        // Set settings page
        Route::get('person/settings', array('before' => 'auth', array($this, 'settings')));

        // Set others routes
        Route::get('person/list', array('before' => 'auth', array($this, 'list_persons')));
        Route::post('person/getlist', array('before' => 'auth', array($this, 'getlist')));

        Route::post('person/getgroups', array('before' => 'auth', array($this, 'list_groups')));
        Route::get('person/editgroup/{id}', array('before' => 'auth', array($this, 'edit_group')));
        Route::post('person/savegroup', array('before' => 'auth', array($this, 'save_group')));

        Route::get('person/emptyperson', array('before' => 'auth', array($this, 'emptyperson')));

        Route::get('person/form', array('before' => 'auth', array($this, 'form')));
        Route::get('person/form/{id}', array('before' => 'auth', array($this, 'form')));

        Route::post('person/save', array('before' => 'auth', array($this, 'save')));
        Route::post('person/save_lang', array('before' => 'auth', array($this, 'save_lang')));
        Route::post('person/save_dynamic_fields', array('before' => 'auth', array($this, 'save_dynamic_fields')));
        Route::post('person/delete', array('before' => 'auth', array($this, 'deleteperson')));

        Route::post('person/save_post_attach', array('before' => 'auth', array($this, 'save_post_attach')));
        Route::post('person/save_person_groups', array('before' => 'auth', array($this, 'save_person_groups')));

        Route::post('person/getaudiences', array('before' => 'auth', array($this, 'getaudiences')));

        // Register new action
        Event::listen('construct_left_menu', array($this, 'left_menu_item'));
        Event::listen('page_attachment', array($this, 'page_group_attachment'));

        Event::listen('language_created', array($this, 'language_created'));
        Event::listen('language_deleted', array($this, 'language_deleted'));

        //Template::registerViewMethod('page', 'persons_list', 'Tabel persoane (consilieri)', null, true);
        Template::registerViewMethod('page', 'group_with_persons', 'Grupe de persoane', null, true);
        Template::registerViewMethod('page', 'persons_with_photo', 'Personalități', null, true);
        Template::registerViewMethod('page', 'persons_big', 'Viceprimar', null, true);
        Template::registerViewMethod('page', 'persons_mayor', 'Primar', null, true);
        Template::registerViewMethod('page', 'persons_secretar', 'Secretar', array($this, 'secretar'), true);
        Template::registerViewMethod('page', 'city_councilors', 'Consilieri locali', null, true);

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
        if (User::has('person-view')) {
            echo Template::moduleView($this->module_name, 'views.person-left-menu');
        }
    }

    /**
     * jqgrid view with persons list
     * @return layout
     */
    public function list_persons() {
        User::onlyHas('person-view');

        $data = array(
            'module' => $this->module_name
        );

        $this->layout->content = Template::moduleView($this->module_name, 'views.list', $data);

        return $this->layout;
    }

    /**
     * get list of persons for jqgrid
     * @return json
     */
    public function getlist() {
        User::onlyHas('person-view');

        $jqgrid = new jQgrid('apl_person', 'person_id');
        echo $jqgrid->populate(function ($start, $limit) {
            $persons = PersonLangModel::select('person_id', 'first_name', 'last_name')
                    ->where('lang_id', Language::getId())
                    ->skip($start)
                    ->take($limit)
                    ->orderBy(DB::raw(\PersonLangModel::getField('first_name') . ', ' . \PersonLangModel::getField('last_name')), 'asc')
                    ->get();

            foreach ($persons as &$person) {
                $groups = \PersonRelModel::join(\PersonGroupLang::getTableName(), \PersonRelModel::getField('group_id'), '=', \PersonGroupLang::getField('group_id'))
                        ->select(\PersonGroupLang::getField('name'))
                        ->where(\PersonRelModel::getField('person_id'), $person->person_id)
                        ->where(\PersonGroupLang::getField('lang_id'), '=', \WebAPL\Language::getId())
                        ->get();

                $array_groups = [];
                foreach ($groups as $group) {
                    $array_groups[] = $group->name;
                }
                $person['group'] = $array_groups ? implode(', ', $array_groups) : '---';
            }

            return $persons;
        });
    }

    public function getaudiences() {
        User::onlyHas('person-view');

        $jqgrid = new jQgrid(PersonAudienceModel::getTableName(), PersonAudienceModel::getField('id'));
        echo $jqgrid->populate(function ($start, $limit) {
            return PersonAudienceModel::select(PersonAudienceModel::getField('id'), DB::raw('CONCAT(first_name, " ", last_name) AS full_name'), PersonAudienceModel::getField('name'), PersonAudienceModel::getField('phone'), PersonAudienceModel::getField('email'), PersonAudienceModel::getField('date_created'))
                            ->join(PersonLangModel::getTableName(), PersonAudienceModel::getField('person_id'), '=', PersonLangModel::getField('person_id'))
                            ->where(PersonLangModel::getField('lang_id'), Language::getId())
                            ->orderBy(PersonAudienceModel::getField('date_created'), 'desc')
                            ->skip($start)
                            ->take($limit)
                            ->get();
        });
    }

    /**
     * Get groups list for jqgrid
     * @return json
     */
    public function list_groups() {
        User::onlyHas('person-view');

        $jqgrid = new jQgrid('apl_person_group', 'id');
        echo $jqgrid->populate(function ($start, $limit) {
            return DB::table('apl_person_group')
                            ->select('apl_person_group.id', 'apl_person_group_lang.name')
                            ->leftJoin('apl_person_group_lang', 'apl_person_group_lang.group_id', '=', 'apl_person_group.id')
                            ->where('apl_person_group_lang.lang_id', Language::getId())
                            ->skip($start)
                            ->take($limit)
                            ->get();
        });
    }

    /**
     * Edit form group
     * @param type $group_id
     * @return type
     */
    public function edit_group($group_id = 0) {
        User::onlyHas('person-group-edit');

        $data = array(
            'group' => PersonGroup::find($group_id),
            'group_lang' => array()
        );

        if ($data['group']) {
            $group_lang = PersonGroupLang::where('group_id', $group_id)->get();
            foreach ($group_lang as $glang) {
                $data['group_lang'][$glang->lang_id] = $glang;
            }

            $this->layout->content = Template::moduleView($this->module_name, 'views.group-edit', $data);
            return $this->layout;
        } else {
            \App::abort(404);
        }
    }

    /**
     * Save group changes
     * @return Redirect / null
     * @throws Exception
     */
    public function save_group() {
        User::onlyHas('person-group-edit');

        $id = Input::get('id');
        $langs = Input::get('lang');
        $glang_id = Input::get('glang_id');
        $lang_id = Input::get('lang_id');

        if ($id) {
            // if group exist
            if ($glang_id) {
                // if groupLang exist, update it
                $personGroupLang = PersonGroupLang::find($glang_id);
                if ($personGroupLang) {
                    $personGroupLang->name = $langs['name'];
                    $personGroupLang->description = $langs['description'];
                    $personGroupLang->save();
                } else {
                    throw new Exception("PersonGroupLang not found #{$glang_id}, DATA: " . serialize($langs));
                }
            } else {
                // if groupLang to exist, create new
                $personGroupLang = new PersonGroupLang;
                $personGroupLang->name = $langs['name'];
                $personGroupLang->description = $langs['description'];
                $personGroupLang->lang_id = $lang_id;
                $personGroupLang->group_id = $id;
                $personGroupLang->save();
            }
        } else {
            // if group not exist
            $personGroup = new PersonGroup;
            $personGroup->date_created = date('Y-m-d H:i:s');
            $personGroup->save();
            $id = $personGroup->id;

            foreach ($langs as $lang_id => $lang) {
                $personGroupLang = new PersonGroupLang;
                $personGroupLang->name = $lang['name'];
                //$personGroupLang->description = $lang['description'];
                $personGroupLang->lang_id = $lang_id;
                $personGroupLang->group_id = $id;
                $personGroupLang->save();
            }
            return Redirect::to('person/editgroup/' . $id);
        }
    }

    /**
     * Edit / create person
     * @param person id $id
     * @return layout
     */
    public function form($id = 0) {
        User::onlyHas('person-edit');

        $data = array(
            'person' => PersonModel::find($id),
            'person_lang' => array(),
            'module' => $this->module_name,
            'person_groups' => PersonGroup::join(PersonGroupLang::getTableName(), PersonGroupLang::getField("group_id"), '=', PersonGroup::getField('id'))
                    ->select(PersonGroup::getField("id"), PersonGroupLang::getField("name"))
                    ->where(PersonGroupLang::getField("lang_id"), \WebAPL\Language::getId())
                    ->orderBy(\PersonGroupLang::getField('name'), 'asc')
                    ->get(),
            'selected_groups' => array()
        );

        if ($data['person']) {
            $personLangs = PersonModel::find($id)->langs()->get();
            foreach ($personLangs as $personLang) {
                $data['person_lang'][$personLang->lang_id] = $personLang;
            }

            $groups = PersonRelModel::where('person_id', $data['person']->id)->get();
            foreach ($groups as $group) {
                $data['selected_groups'][] = $group->group_id;
            }
        }

        $data['feeds'] = \Feed::orderBy('name', 'asc')->get();

        $this->layout->content = Template::moduleView($this->module_name, 'views.form', $data);
        return $this->layout;
    }

    public function save_person_groups() {
        User::onlyHas('person-group-edit');

        $person_id = Input::get('id');
        $groups = Input::get('groups');
        PersonRelModel::where('person_id', $person_id)->delete();
        foreach ($groups as $group) {
            PersonRelModel::insert(array(
                'person_id' => $person_id,
                'group_id' => $group
            ));
        }
    }

    public function emptyperson() {
        User::onlyHas('person-edit');

        $person = new PersonModel;
        $person->save();

        foreach (\WebAPL\Language::getList() as $lang) {
            $person_lang = new PersonLangModel;
            $person_lang->person_id = $person->id;
            $person_lang->lang_id = $lang->id;
            $person_lang->save();
        }

        return Redirect::to('person/form/' . $person->id);
    }

    /**
     * Save changes
     * @return array/json
     */
    public function save() {
        User::onlyHas('person-edit');

        $id = Input::get('id');


        if ($id) {
            // if the person exist, find
            $person = PersonModel::find($id);
            if (!$person) {
                throw new Exception('Person not found #' . $id);
            }
        } else {
            // if the person does not exist, create new
            $person = new PersonModel;
        }
        $person->feed_id = Input::get('feed_id');
        $person->user_id = Input::get('user_id');
        $person->phone = Input::get('phone');
        $person->email = Input::get('email');
        $person->date_birth = Input::get('date_birth');
//        $person->for_audience = Input::get('for_audience') ? 1 : 0;
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
        User::onlyHas('person-edit');

        $person_id = Input::get('person_id');
        $person_lang_id = Input::get('person_lang_id');
        $new_person_id = 0;

        $redirect_to = '';

        if ($person_lang_id) {
            // if the person-lang exist, find
            $person_lang = PersonLangModel::find($person_lang_id);
        } else {
            if (!$person_id) {
                // if the person does not exist, create empty person record
                $person = new PersonModel;
                $person->save();
                $new_person_id = $person->id;
                $redirect_to = url('person/form/' . $new_person_id);
            }

            // if the person-lang does not exist, create new
            $person_lang = new PersonLangModel;
            $redirect_to = url('person/form/' . $person_id);
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
        $person_lang->text = Input::get("text.{$person_lang_id}");
        $person_lang->save();

        if ($redirect_to) {
            // if person has been created, refresh page
            return array(
                'redirect_to' => $redirect_to
            );
        }
    }

    /**
     * Save dynamic field for person
     */
    public function save_dynamic_fields() {
        User::onlyHas('person-edit');

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

        // unset last rows
        if ($rows)
            unset($rows[count($rows) - 1]);

        // Update rows
        $person = PersonModel::find($person_id);
        if ($person) {
            $person->dynamic_fields = serialize($rows);
            $person->save();
        } else {
            throw new Exception("Undefined person, BAG: rows-" . serialize($rows));
        }
    }

    public function page_group_attachment($post) {
        if (in_array($post->view_mod, array('persons_list', 'city_councilors', 'persons_big', 'persons_secretar', 'persons_mayor', 'group_with_persons', 'persons_with_photo'))) {
            $wdata = array(
                'post' => $post->toArray(),
                'person_groups' => PersonGroup::join(PersonGroupLang::getTableName(), PersonGroupLang::getField("group_id"), '=', PersonGroup::getField('id'))
                        ->select(PersonGroup::getField("id"), PersonGroupLang::getField("name"))
                        ->where(PersonGroupLang::getField("lang_id"), \WebAPL\Language::getId())
                        ->orderBy(\PersonGroupLang::getField('name'), 'asc')
                        ->get()->toArray(),
                'selected_groups' => array()
            );

            $selected_groups = PersonGroupPostModel::where('post_id', $post->id)->get();
            foreach ($selected_groups as $item) {
                $wdata['selected_groups'][] = $item->group_id;
            }

            echo Template::moduleView($this->module_name, 'views.attachment-group-page', $wdata);
        }
    }

    public function save_post_attach() {
        $page_id = Input::get('page_id');
        $groups = Input::get('groups');
        PersonGroupPostModel::where('post_id', $page_id)->delete();
        foreach ($groups as $group) {
            $item = new PersonGroupPostModel;
            $item->post_id = $page_id;
            $item->group_id = $group;
            $item->save();
        }
        return array();
    }

    public function language_created($lang_id) {
        $plist = \PersonModel::all();
        foreach ($plist as $ent) {
            $item = new \PersonLangModel;
            $item->person_id = $ent->id;
            $item->lang_id = $lang_id;
            $item->save();
        }

        $glist = \PersonGroup::all();
        foreach ($glist as $ent) {
            $item = new \PersonGroupLang;
            $item->group_id = $ent->id;
            $item->lang_id = $lang_id;
            $item->save();
        }
    }

    public function language_deleted($lang_id) {
        PersonLangModel::where('lang_id', $lang_id)->delete();
        PersonGroupLang::where('lang_id', $lang_id)->delete();
    }

    public function deleteperson() {
        $id = Input::get('id');

        \PersonModel::where('id', $id)->delete();
        \PersonLangModel::where('person_id', $id)->delete();
        \Files::dropMultiple('person', $id);
        \Files::dropMultiple('person_chat', $id);
        \PersonRelModel::where('person_id', $id)->delete();

        return \Illuminate\Support\Facades\Redirect::to('person/list');
    }

}
