<?php

/**
 *
 *
 * @author     Godina Nicolae <ngodina@ebs.md>
 * @copyright  2014 Enterprise Business Solutions SRL
 * @link       http://ebs.md/
 */
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
        User::onlyHas("settings-view");

        $this->data['setts'] = SettingsModel::getAll();

        $this->layout->content = View::make('sections.template.change', $this->data);
    }

    public function postInstall() {
        User::onlyHas("settings-view");

        $extract_path = Files::fullDir("upload/tmp/tpl/");

        if (file_exists($extract_path) === FALSE) {
            @mkdir($extract_path, 0777, true);
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
                        if (isset($config['name']) && !file_exists(Files::fullDir('apps/' . $config['app'] . '/views/template/' . $config['name'] . '/'))) {
                            $template_folder = $extract_path . $config['name'] . '/';
                            if (file_exists($template_folder)) {
                                rename($template_folder, Files::fullDir('apps/' . $config['app'] . '/views/template/' . $config['name'] . '/'));

                                $returnData['message'] = "Succeful";
                                $returnData['message_type'] = 'alert-success';
                            } else {
                                $returnData['message'] = "Template not found in zip";
                                $returnData['message_type'] = 'alert-danger';
                            }
                        } else {
                            $returnData['message'] = "Undefined template name or already exists";
                            $returnData['message_type'] = 'alert-danger';
                        }
                    } else {
                        $returnData['message'] = "Undefined app name";
                        $returnData['message_type'] = 'alert-danger';
                    }

                    File::deleteDirectory($extract_path);
                } else {
                    $returnData['message'] = "INSTALL.PHP is required";
                    $returnData['message_type'] = 'alert-danger';
                }
                $zip->close();
            } else {
                $returnData['message'] = "Invalid zip";
                $returnData['message_type'] = 'alert-danger';
            }
        } else {
            $returnData['message'] = "Invalid file";
            $returnData['message_type'] = 'alert-danger';
        }

        return Redirect::to('template')->with($returnData);
    }

}
