<?php

class PostResources {

    public static function init() {
        \Core\APL\Shortcodes::register('contact', array('PostResources', 'blockContact'));
        \Core\APL\Shortcodes::register('harta', ['PostResources', 'insertMap']);
    }

    public static function insertMap() {
        return "<div id=\"map-canvas2\" style='width:100%;height:400px;'>&nbsp;</div>";
    }
    
    public static function blockContact($params) {
        return View::make('sections.pages.blocks.contactDiv', $params);
    }

    public static function contactSubmit() {

        $data = array(
            varlang('name-last-name') => Input::get('name'),
            varlang('email') => Input::get('email'),
            varlang('adresa-telefon') => Input::get('address'),
            varlang('subiect') => Input::get('subject'),
            varlang('message') => Input::get('message'),
            varlang('cod-verificare') => SimpleCapcha::valid('contact', Input::get('capcha')) ? 1 : null
        );

        $validator = Validator::make($data, array(
                    varlang('name-last-name') => 'required',
                    varlang('email') => 'email|required',
                    varlang('message') => 'required',
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
            SimpleCapcha::destroy('contact');
            EmailModel::sendToAdmins("Contact form", 'email.contact', $data);
            $return['html'] = "Mesajul dvs a fost receptionat";
        }

        return $return;
    }

    public static function contactTopSubmit() {

        $data = array(
            varlang('name-last-name') => Input::get('name'),
            varlang('email') => Input::get('email'),
            varlang('message') => Input::get('message'),
            varlang('cod-verificare') => SimpleCapcha::valid('contact_top', Input::get('capcha')) ? 1 : null
        );

        $validator = Validator::make($data, array(
                    varlang('name-last-name') => 'required',
                    varlang('email') => 'email|required',
                    varlang('message') => 'required',
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
