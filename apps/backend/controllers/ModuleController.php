<?php

class ModuleController extends BaseController {

    function __construct() {
        parent::__construct();

        $this->beforeFilter(function() {
            if (!Auth::check()) {
                return Redirect::to('auth');
            }
        });
    }

    protected $layout = 'layout.main';

    public function getIndex() {
        $this->data['modules'] = Module::all();

        $this->layout->content = View::make('sections.module.list')->with($this->data);
    }

    public function postInstall() {

        if (isset($_FILES['module'])) {
            $zip = new ZipArchive;

            $result = $zip->open($_FILES['module']['tmp_name']);

            if ($result) {

                // get install, frontent and backend files
                $files = array();
                for ($i = 0; $i < $zip->numFiles; $i++) {
                    $files[] = $zip->getNameIndex($i);
                }

                if (!in_array('install.php', $files)) {
                    echo "INSTALL.PHP is required";
                    return;
                }


                // extract files
                $zip->extractTo($_SERVER['DOCUMENT_ROOT'] . "/tmp/zip/");

                //rename($_SERVER['DOCUMENT_ROOT'] . "/tmp/zip/backend/", $_SERVER['DOCUMENT_ROOT'] . "/apps/backend/modules/");
                //rename($_SERVER['DOCUMENT_ROOT'] . "/tmp/zip/frontend/", $_SERVER['DOCUMENT_ROOT'] . "/apps/frontend/modules/");
                
                require_once $_SERVER['DOCUMENT_ROOT'] .  '/tmp/zip/install.php';
                
                array_map('unlink', glob($_SERVER['DOCUMENT_ROOT'] ."/tmp/zip/*"));
                $zip->close();

                
            } else {
                
            }
        }

        Redirect::to('module');
        
        $this->layout = null;
    }

    public function getEnable($id) {
        Module::changeState($id, 1);

        return Redirect::to('module');
    }

    public function getDisable($id) {
        Module::changeState($id, 0);

        return Redirect::to('module');
    }

    public function getZip() {
        global $_SERVER;
        $zip = new ZipArchive;

        $result = $zip->open($_SERVER['DOCUMENT_ROOT'] . "/tmp/zipfile/file.zip");
        if ($result === TRUE) {
            $zip->extractTo($_SERVER['DOCUMENT_ROOT'] . "/tmp/zipextract");
            $zip->close();

            echo "succes";
        } else {
            echo "error";
        }

        $this->layout = null;
    }

}
