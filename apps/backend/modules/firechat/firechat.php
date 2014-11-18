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
    FireBaseAuth,
    JWT,
    Route,
    Event,
    FireChatSession;

class Firechat extends \WebAPL\ExtensionController {

    protected $module_name = 'firechat';
    protected $layout;

    public function __construct() {
        parent::__construct();

        $this->loadClass(array('FireChatSession', 'FireBaseAuth'));

        Route::get('firechat', array('before' => 'auth', array($this, 'view')));
        Route::get('firechat/display', array('before' => 'auth', array($this, 'display')));
        Route::post('firechat/closeroom', array('before' => 'auth', array($this, 'closeroom')));
        Route::post('firechat/audience', array('before' => 'auth', array($this, 'audience')));
        Route::post('firechat/sendmail', array('before' => 'auth', array($this, 'sendmail')));

        Route::get('firechat/settings', array('before' => 'auth', array($this, 'settings')));

        Event::listen('construct_left_menu', array($this, 'left_menu_item'));

        $this->layout = Template::mainLayout();
    }

    public function view() {
        \User::onlyHas('chat-view');

        $data = array(
            'person' => \PersonModel::where('user_id', \Auth::user()->id)->first(),
        );

        $this->layout->content = Template::moduleView($this->module_name, 'views.chat-form', $data);

        return $this->layout;
    }

    public function settings() {
        \User::onlyHas('chat-view');

        $data['setts'] = \SettingsModel::getAll();

        $this->layout->content = Template::moduleView($this->module_name, 'views.chat-settings', $data);

        return $this->layout;
    }

    public function display() {
        \User::onlyHas('chat-view');

        $data = array(
            'person' => \PersonModel::where('user_id', \Auth::user()->id)->first(),
        );

        if ($data['person']) {

            $tokenGen = new FireBaseAuth(\SettingsModel::one('firechat_key'));
            $data['token'] = $tokenGen->createToken(array("uid" => "person-{$data['person']->id}"), array("admin" => True));

            $data['person_lang'] = $data['person']->langs()->where('lang_id', \WebAPL\Language::getId())->first();

            return Template::moduleView($this->module_name, 'views.chat-display', $data);
        } else {
            throw new Exception('Person not found');
        }
    }

    public function left_menu_item() {
        if (\User::has('chat-view')) {
            echo Template::moduleView($this->module_name, 'views.chat-left-menu');
        }
    }

    public function closeroom() {
        \User::onlyHas('chat-view');

        $roomId = \Input::get('roomId');
        $person_id = \Input::get('person_id');

        FireChatSession::where(array(
            'roomId' => $roomId,
            'person_id' => $person_id
        ))->update(array(
            'active' => 0
        ));

        return [];
    }

    public function audience() {
        $id = \Input::get('id');
        $for_audience = \Input::get('for_audience');

        if ($id) {
            $person = \PersonModel::find($id);
            if ($person) {
                $person->for_audience = $for_audience ? 1 : 0;
                $person->save();
            }
        }

        return [];
    }

    public function sendmail() {
        $id = \Input::get('id');
        $html = \Input::get('messages');

        $person = \PersonModel::find($id);

        if ($person) {
            $data['html'] = $html;
            Template::viewModule($this->module_name, function () use ($data, $person) {
                \Mail::send('views.email-mess', $data, function($message) use ($person) {
                    $message->from("noreply@{$_SERVER['SERVER_NAME']}", 'WebLPA');
                    $message->subject("Discutie on-line din " . date("Y-m-d H:i"));
                    $message->to($person->email);
                });
            });
        }
    }

}
