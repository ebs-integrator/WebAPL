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
 
class TemplateController extends BaseController {

    function __construct() {
        parent::__construct();

        $this->beforeFilter(function() {
            if (!Auth::check()) {
                return Redirect::to('auth');
            }
        });
    }

    protected $taxonomy;
    protected $layout = 'layout.main';

    public function getIndex() {
        User::onlyHas("template-edit");

        $this->data['setts'] = SettingsModel::getAll();

        $this->layout->content = View::make('sections.template.change', $this->data);
    }

    public function postInstall() {
        User::onlyHas("template-install");

        $extract_path = Files::fullDir("upload/tmp/tpl/");

        if (file_exists($extract_path) === FALSE) {
            mkdir($extract_path, 0777, true);
        }

        $returnData = [];

        if (isset($_FILES['template'])) {
            $zip = new ZipArchive;

            $result = $zip->open($_FILES['template']['tmp_name']);

            if ($result === TRUE) {
                if ($zip->locateName('install.php') !== false) {
                    // extract files
                    $zip->extractTo($extract_path);

                    //rename($_SERVER['DOCUMENT_ROOT'] . "/tmp/zip/backend/", $_SERVER['DOCUMENT_ROOT'] . "/apps/backend/modules/");
                    //rename($_SERVER['DOCUMENT_ROOT'] . "/tmp/zip/frontend/", $_SERVER['DOCUMENT_ROOT'] . "/apps/frontend/modules/");
                    // get template settings
                    $config = require_once $extract_path . 'install.php';

                    if (isset($config['app']) && file_exists(Files::fullDir('apps/' . $config['app'] . '/'))) {
                        $template_newfolder = Files::fullDir('apps/' . $config['app'] . '/views/templates/' . $config['name'] . '/');
                        if (isset($config['name']) && file_exists($template_newfolder) === FALSE) {
                            $template_folder = $extract_path . $config['name'] . '/';
                            if (file_exists($template_folder)) {
                                mkdir($template_newfolder);

                                rename($template_folder, $template_newfolder);

                                $returnData['message'] = varlang('tpl-succeful');
                                $returnData['message_type'] = 'alert-success';
                            } else {
                                $returnData['message'] = varlang('template-not-found-in-zip');
                                $returnData['message_type'] = 'alert-danger';
                            }
                        } else {
                            $returnData['message'] = varlang('undefined-template-name-or-already-exists');
                            $returnData['message_type'] = 'alert-danger';
                        }
                    } else {
                        $returnData['message'] = varlang('undefined-app-name');
                        $returnData['message_type'] = 'alert-danger';
                    }

                    File::deleteDirectory($extract_path);
                } else {
                    $returnData['message'] = varlang('installphp-is-required');
                    $returnData['message_type'] = 'alert-danger';
                }
                $zip->close();
            } else {
                $returnData['message'] = varlang('invalid-zip');
                $returnData['message_type'] = 'alert-danger';
            }
        } else {
            $returnData['message'] = varlang('invalid-file');
            $returnData['message_type'] = 'alert-danger';
        }

        return Redirect::to('template')->with($returnData);
    }

    public function getDelete($app, $template) {
        User::onlyHas('template-delete');

        $templateDir = Files::fullDir('apps/' . $app . '/views/templates/' . $template . '/');
        if (file_exists($templateDir)) {
            File::deleteDirectory($templateDir);
            $returnData['message'] = varlang('template-deleted');
            $returnData['message_type'] = 'alert-success';
        } else {
            $returnData['message'] = varlang('template-not-found-1');
            $returnData['message_type'] = 'alert-danger';
        }

        return Redirect::to('template')->with($returnData);
    }

}
