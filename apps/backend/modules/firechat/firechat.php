<?php

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
        var_dump($person->email);
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
