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
        User::onlyHas("modules-view");

        $this->data['modules'] = Module::all();

        $this->layout->content = View::make('sections.module.list')->with($this->data);
    }

    public function postInstall() {
        User::onlyHas("modules-view");

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

                require_once $_SERVER['DOCUMENT_ROOT'] . '/tmp/zip/install.php';

                array_map('unlink', glob($_SERVER['DOCUMENT_ROOT'] . "/tmp/zip/*"));
                $zip->close();
            } else {
                
            }
        }

        Redirect::to('module');

        $this->layout = null;
    }

    public function getEnable($id) {
        User::onlyHas("modules-view");

        Module::changeState($id, 1);

        Log::info("Enable module #{$id}");

        return Redirect::to('module');
    }

    public function getDisable($id) {
        User::onlyHas("modules-view");

        Module::changeState($id, 0);

        Log::info("Disable module #{$id}");

        return Redirect::to('module');
    }

    public function getZip() {
        User::onlyHas("modules-view");

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
