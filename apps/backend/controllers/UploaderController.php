<?php

class UploaderController extends BaseController {

    function __construct() {
        parent::__construct();

        $this->beforeFilter(function() {
            if (!Auth::check()) {
                return Redirect::to('auth');
            }
        });
    }

    public function filelist() {
        $files = Files::file_list(Input::get('module_name'), Input::get('module_id'));

        $data = array();
        $data['html'] = View::make('sections.file.file_list')->with(array(
                    'module_name' => Input::get('module_name'),
                    'module_id' => Input::get('module_id'),
                    'num' => Input::get('num'),
                    'files' => $files
                ))->render();

        return $data;
    }

    public function start() {
        $data = array(
            'module_id' => Input::get('module_id'),
            'module_name' => Input::get('module_name'),
            'num' => Input::get('num')
        );
        if (Input::hasFile('upload_file')) {
            $file = Input::file('upload_file');

            $extension = $file->getClientOriginalExtension();
            $name = $file->getClientOriginalName();

            $filename = uniqid() . '_' . md5($name) . "." . $extension;

            $uploadSuccess = $file->move(Files::fullDir(), $filename);

            if ($uploadSuccess) {
                Files::register($name, $filename, $extension, $data['module_name'], $data['module_id']);

                $data['error'] = '0';
                $data['succes'] = 'Uploaded!';
            } else {
                $data['error'] = '1';
                $data['succes'] = 'Error!';
            }
        } else {
            $data['error'] = '1';
            $data['succes'] = 'Upload file not found';
        }
        return $data;
    }

    public function delete() {
        $id = Input::get('id');
        $data = array(
            'deleted' => 0
        );
        if ($id) {
            $data['deleted'] = Files::drop($id);
        }
        return $data;
    }

}
