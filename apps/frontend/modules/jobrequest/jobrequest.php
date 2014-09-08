<?php

namespace Core\APL\Modules;

use Core\APL\Actions,
    Core\APL\Template,
    Core\APL\Shortcodes,
    Input,
    Validator,
    JobRequestModel;

class Jobrequest extends \Core\APL\ExtensionController {

    protected $module_name = 'jobrequest';
    protected $layout;

    public function __construct() {
        parent::__construct();

        $this->loadClass(array('JobRequestModel'));

        Shortcodes::register('cv_form', array($this, 'cv_form'));
        Actions::post('job/apply', array($this, 'cv_form_submit'));
    }

    public function cv_form($attr) {
        if (isset($attr['post'])) {
            return Template::moduleView($this->module_name, 'views.job-form', array('post_id' => $attr['post']['id']));
        }
    }

    public function cv_form_submit() {
        $validator = Validator::make(array(
                    'post_id' => Input::get('post_id'),
                    'name' => Input::get('name'),
                    'upload' => Input::file('upload'),
                        ), array(
                    'post_id' => 'required',
                    'name' => 'required',
                    'upload' => 'required|mimes:pdf',
        ));

        $return = array(
            'message' => '',
            'error' => 0
        );

        if ($validator->fails()) {
            $return['message'] = implode('<br>', $validator->messages()->all(':message<br>'));
            $return['error'] = 1;
        } else {
            $post_id = Input::get('post_id');

            $audience = new JobRequestModel;
            $audience->post_id = $post_id;
            $audience->name = Input::get('name');
            $audience->save();

            if (Input::file('upload')->isValid()) {
                Input::file('upload')->move($_SERVER['DOCUMENT_ROOT']."/upload/cv/", 'cv_' . $post_id . '_' . date("Y-m-d") . '_' . uniqid() . '.pdf');
            } else {
                $return['message'] = 'Invalid file';
                $return['error'] = 1;
            }
        }

        return $return;
    }

}
