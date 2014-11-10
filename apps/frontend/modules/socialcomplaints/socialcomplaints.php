<?php

namespace Core\APL\Modules;

use Core\APL\Actions,
    Core\APL\Shortcodes,
    Core\APL\Template,
    PageView,
    Input,
    Validator,
    Route,
    SComplaintsModel;

class Socialcomplaints extends \Core\APL\ExtensionController {

    protected $module_name = 'socialcomplaints';
    protected $layout;

    public function __construct() {
        parent::__construct();

        $this->loadClass(array(
            'SComplaintsModel'
        ));

        // Set settings page
        Shortcodes::register('complaint_form', array($this, 'complaint_form'));
        Route::post("create_complaint", array($this, 'create_complaint'));

        Template::registerViewMethod('page', 'secial_complaints_list', 'Lista cu plingeri', array($this, 'secial_complaints_list'), true);
    }

    public function complaint_form() {
        return Template::moduleView($this->module_name, 'views.complaint_form');
    }

    public function secial_complaints_list($data) {

        $wdata = array(
            'complaints' => SComplaintsModel::where('enabled', 1)->where('is_private', 0)->where('post_id', $data['page']->id)->orderBy('date_created', 'desc')->paginate(5)
        );

        $data['page']->text = Template::moduleView($this->module_name, 'views.complaints_list', $wdata) . $data['page']->text;

        return PageView::defaultView($data);
    }

    public function create_complaint() {

        $validator = Validator::make(array(
                    varlang('numele-prenume') => Input::get('name'),
                    varlang('email') => Input::get('email'),
                    varlang('subiect-1') => Input::get('subject'),
                    varlang('cod-de-verificare') => \SimpleCapcha::valid('complaint', Input::get('capcha')) ? 1 : null
                        ), array(
                    varlang('numele-prenume') => 'required',
                    varlang('email') => 'email|required',
                    varlang('subiect-1') => 'required',
                    varlang('cod-de-verificare') => 'required'
        ));

        $return = array(
            'message' => '',
            'error' => 0
        );

        if ($validator->fails()) {
            $return['message'] = implode(' ', $validator->messages()->all('<p>:message</p>'));
            $return['error'] = 1;
        } else {
            $complaint = new SComplaintsModel;
            $complaint->username = Input::get('name');
            $complaint->email = Input::get('email');
            $complaint->address = Input::get('address');
            $complaint->title = Input::get('subject');
            $complaint->text = Input::get('message');
            $complaint->is_private = Input::get('private');
            $complaint->save();

            Template::viewModule($this->module_name, function () use ($complaint) {
                $sendToUsers = \User::withRole('user-getemails');

                $data['complaint'] = $complaint;
                foreach ($sendToUsers as $user) {
                    $data['user'] = $user;
                    \Mail::send('views.complaint_email', $data, function($message) use ($user) {
                        $message->from("noreply@{$_SERVER['SERVER_NAME']}", 'WebLPA');
                        $message->subject("New message");
                        $message->to($user->email);
                    });
                }
            });
        }

        return $return;
    }

}
