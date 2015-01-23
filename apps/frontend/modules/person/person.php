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
    Route,
    View,
    PageView;

class Person extends \WebAPL\ExtensionController {

    protected $module_name = 'person';
    protected $layout;
    public static $view_group_with_persons = 'person::person_groups';
    public static $view_persons_with_photo = 'person::person_photos';
    public static $view_persons_big = 'person::person_mayors';
    public static $view_persons_mayor = 'person::person_mayor';
    public static $view_persons_secretar = 'person::person_secretar';
    public static $view_city_councilors = 'person::person_councilors';

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

        Route::post('person/subscribe_to_audience', array($this, 'subscribe_to_audience'));

        View::addNamespace('person', app_path('/modules/person/views'));
        
        $online_persons = \PersonModel::where('for_audience', 1)->get();
        $online_persons_arr = [];
        foreach ($online_persons as $person) {
            $online_persons_arr[] = $person->id;
        }
        View::share('online_persons', $online_persons_arr);
    }
    
    public function group_list($data) {
        $groups = PersonModel::getPostPersonGroups($data['page']->id);
        if ($groups) {
            $data["page"]->text = View::make(Person::$view_group_with_persons, array('groups' => $groups));
        }

        return PageView::defaultView($data);
    }

    public function councilors($data) {
        $groups = PersonModel::getPostPersonGroups($data['page']->id);
        if ($groups) {
            $data["page"]->text = View::make(Person::$view_city_councilors, array('groups' => $groups));
        }

        return PageView::defaultView($data);
    }

    public function photo_persons($data) {
        $groups = PersonModel::getPostPersonGroups($data['page']->id);
        if ($groups) {
            $data["page"]->text = View::make(Person::$view_persons_with_photo, array('groups' => $groups));
        }

        return PageView::defaultView($data);
    }

    public function vicemayor($data) {

        $item = Input::get('item');
        if ($item) {
            $person = \PersonModel::getPerson($item);
            if ($person) {
                $groups = [['persons' => [$person]]];
                $data["page"]->text = View::make(Person::$view_persons_secretar, array('groups' => $groups));
                return PageView::defaultView($data);
            }
        }

        $groups = PersonModel::getPostPersonGroups($data['page']->id);
        if ($groups) {
            $data["page"]->text = View::make(Person::$view_persons_big, array('groups' => $groups, 'page_url' => $data['page_url']));
        }

        return PageView::defaultView($data);
    }

    public function mayor($data) {
        $groups = PersonModel::getPostPersonGroups($data['page']->id);
        if ($groups) {
            $data["page"]->text = View::make(Person::$view_persons_mayor, array('groups' => $groups));
        }

        return PageView::defaultView($data);
    }

    public function secretar($data) {
        $groups = PersonModel::getPostPersonGroups($data['page']->id);
        if ($groups) {
            $data["page"]->text = View::make(Person::$view_persons_secretar, array(
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
                    ->where(PersonLangModel::getField('lang_id'), \WebAPL\Language::getId())
                    ->get()
        );
        return View::make('person::block_subscribe', $data);
    }

    public function subscribe_to_audience() {
        $validator = Validator::make(array(
                    'person_id' => Input::get('person_id'),
                    varlang('email') => Input::get('email'),
                    varlang('name-last-name') => Input::get('name'),
                    varlang('telefon') => Input::get('phone'),
                    varlang('cod-verificare') => SimpleCapcha::valid('person_subscribe', Input::get('capcha')) ? 1 : null
                        ), array(
                    'person_id' => 'required',
                    varlang('name-last-name') => 'required',
                    varlang('email') => 'email|required',
                    varlang('telefon') => 'required',
                    varlang('cod-verificare') => 'required'
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
