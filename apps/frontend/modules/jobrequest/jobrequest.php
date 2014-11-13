<?php

/**
 * 
 * CMS WebAPL 1.0. Platform is a free open source software for creating an managing
 * their full with CMS integrated CMS system
 * 
 * Copyright (C) 2014 Enterprise Business Solutions SRL
 * 
 * This program is free software: you can redistribute it and/or modify it under
 * the terms of the GNU General Public License as published by the Free Software
 * Foundation, either version 3 of the License, or any later version.
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A
 * PARTICULAR PURPOSE. See the GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License along with
 * this program.  If not, see <http://www.gnu.org/licenses/>.
 * You can read the copy of GNU General Public License in english here 
 * 
 * For more details about CMS WebAPL 1.0 please contact Enterprise Business
 * Solutions SRL, Republic of Moldova, MD 2001, Ion Inculet 33 Street or send an
 * email to office@ebs.md 
 * 
 */
namespace WebAPL\Modules;

use WebAPL\Actions,
    WebAPL\Template,
    WebAPL\Shortcodes,
    Input,
    Validator,
    Route,
    Event,
    JobRequestModel;

class Jobrequest extends \WebAPL\ExtensionController {

    protected $module_name = 'jobrequest';
    protected $layout;

    public function __construct() {
        parent::__construct();

        $this->loadClass(array('JobRequestModel'));

        Shortcodes::register('cv_form', array($this, 'cv_form'));
        Event::listen('cv_form', array($this, 'cv_form_ev'));
        Route::post('job/apply', array($this, 'cv_form_submit'));
    }

    public function cv_form($attr) {
        if (isset($attr['post']) && isset($attr['date']) && (strtotime($attr['date']) == 0 || strtotime($attr['date']) > time())) {
            return "<div class='ldmbox '>" . Template::moduleView($this->module_name, 'views.job-form', array('post_id' => $attr['post']['id'])) . "</div>";
        }
    }

    public function cv_form_ev($post) {
        if (isset($post) && (strtotime($post->date_point) == 0 || strtotime($post->date_point) > time())) {
            echo Template::moduleView($this->module_name, 'views.job-form', array('post_id' => $post['id']))->render();
        }
    }

    public function cv_form_submit() {
        $validator = Validator::make(array(
                    'post_id' => Input::get('post_id'),
                    varlang('name-last-name') => Input::get('name'),
                    varlang('cv') => Input::file('upload'),
                        ), array(
                    'post_id' => 'required',
                    varlang('name-last-name') => 'required',
                    varlang('cv') => 'required',
        ));

        $return = array(
            'message' => '',
            'error' => 0
        );

        if ($validator->fails()) {
            $return['message'] = implode('<br>', $validator->messages()->all(':message'));
            $return['error'] = 1;
        } else {
            $post_id = Input::get('post_id');

            $name = Input::get('name');

            $filename = 'cv_' . $post_id . '_' . date("Y-m-d") . '_' . uniqid() . '.pdf';
            $filepath = "/upload/cv/";

            $audience = new JobRequestModel;
            $audience->post_id = $post_id;
            $audience->name = $name;
            $audience->save();

            $attachFile = false;

            if (Input::file('upload')->isValid()) {
                $audience->cv_path = $filepath . $filename;
                $audience->save();
                $attachFile = $filepath . $filename;
                Input::file('upload')->move($_SERVER['DOCUMENT_ROOT'] . $filepath, $filename);
            } else {
                $return['message'] = 'Invalid file';
                $return['error'] = 1;
            }

            Template::viewModule($this->module_name, function () use ($name, $attachFile) {
                $data['name'] = $name;
                \EmailModel::sendToAdmins("New job reqest", 'views.email-request', $data, $attachFile);
            });
        }

        return $return;
    }

}
