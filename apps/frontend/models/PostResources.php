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
 
class PostResources {

    public static function init() {
        \WebAPL\Shortcodes::register('contact', array('PostResources', 'blockContact'));
        \WebAPL\Shortcodes::register('harta', ['PostResources', 'insertMap']);
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
