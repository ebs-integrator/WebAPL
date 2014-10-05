<?php

class PostResources {

    public static function init() {
        \Core\APL\Shortcodes::register('contact', array('PostResources', 'blockContact'));
    }

    public static function blockContact($params) {
        return View::make('sections.pages.blocks.contactDiv', $params);
    }

    public static function contactSubmit() {

        $data = array(
            'name' => Input::get('name'),
            'email' => Input::get('email'),
            'address' => Input::get('address'),
            'subject' => Input::get('subject'),
            'messages' => Input::get('message'),
            'capcha' => SimpleCapcha::valid('contact', Input::get('capcha')) ? 1 : null
        );

        $validator = Validator::make($data, array(
                    'name' => 'required',
                    'email' => 'email|required',
                    'messages' => 'required',
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
            SimpleCapcha::destroy('contact');
            EmailModel::sendToAdmins("Contact form", 'email.contact', $data);
            $return['html'] = "Mesajul dvs a fost receptionat";
        }

        return $return;
    }

    public static function contactTopSubmit() {

        $data = array(
            'name' => Input::get('name'),
            'email' => Input::get('email'),
            'messages' => Input::get('message'),
            'capcha' => SimpleCapcha::valid('contact_top', Input::get('capcha')) ? 1 : null
        );

        $validator = Validator::make($data, array(
                    'name' => 'required',
                    'email' => 'email|required',
                    'messages' => 'required',
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
            SimpleCapcha::destroy('contact_top');
            EmailModel::sendToAdmins("Contact form", 'email.contact', $data);
            $return['html'] = "Mesajul dvs a fost receptionat";
        }

        return $return;
    }

    public static function rssPage() {
        $data['posts'] = Post::rssPosts();

        return View::make('sections.others.rss', $data);
    }

}
