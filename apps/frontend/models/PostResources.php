<?php

class PostResources {

    public static function init() {
        \Core\APL\Shortcodes::register('contact', array('PostResources', 'blockContact'));
    }

    public static function blockContact($params) {
        return View::make('sections.pages.blocks.contactDiv', $params);
    }

    public static function contactSubmit() {
        $validator = Validator::make(array(
                    'name' => Input::get('name'),
                    'email' => Input::get('email'),
                    'address' => Input::get('address'),
                    'subject' => Input::get('subject'),
                    'message' => Input::get('message'),
                    'capcha' => SimpleCapcha::valid('contact', Input::get('capcha')) ? 1 : null
                        ), array(
                    'name' => 'required',
                    'email' => 'email|required',
                    'message' => 'required',
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
        }

        return $return;
    }

}
