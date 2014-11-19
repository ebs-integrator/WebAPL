<?php

class InstallController extends BaseController {

    protected $layout = 'install::layout';

    public function getIndex() {
        if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/install/installed')) {
            return Illuminate\Support\Facades\Redirect::to('install/final');
        }

        $this->layout->step = 1;
        $this->layout->content = View::make('install::step1');
        return $this->layout;
    }

    public function getStep2() {
        $this->layout->step = 2;

        $data['req']['php_version'] = PHP_VERSION_ID >= 50400;
        $data['req']['mcrypt'] = extension_loaded('mcrypt');
        $data['req']['pdo'] = extension_loaded('pdo_mysql');
        if (function_exists('apache_get_modules')) {
            $data['req']['rewrite'] = in_array('mod_rewrite', apache_get_modules());
        }

        $dirs = array(
            $_SERVER['DOCUMENT_ROOT'] . '/apps/frontend/storage/',
            $_SERVER['DOCUMENT_ROOT'] . '/apps/backend/storage/',
            $_SERVER['DOCUMENT_ROOT'] . '/upload/',
            $_SERVER['DOCUMENT_ROOT'] . '/install/',
            $_SERVER['DOCUMENT_ROOT'] . '/apps/frontend/config/',
            $_SERVER['DOCUMENT_ROOT'] . '/apps/backend/config/'
        );
        foreach ($dirs as $path) {
            $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path), RecursiveIteratorIterator::SELF_FIRST);
            foreach ($iterator as $item) {
                @chmod($item, 0777);
            }
        }

        $data['req']['wr_fr_storage'] = is_writable($_SERVER['DOCUMENT_ROOT'] . '/apps/frontend/storage/');
        $data['req']['wr_bk_storage'] = is_writable($_SERVER['DOCUMENT_ROOT'] . '/apps/backend/storage/');
        $data['req']['wr_upload'] = is_writable($_SERVER['DOCUMENT_ROOT'] . '/upload/');
        $data['req']['wr_install'] = is_writable($_SERVER['DOCUMENT_ROOT'] . '/install/');
        $data['req']['wr_fr_db'] = is_writable($_SERVER['DOCUMENT_ROOT'] . '/apps/frontend/config/');
        $data['req']['wr_bk_db'] = is_writable($_SERVER['DOCUMENT_ROOT'] . '/apps/backend/config/');


        $data['valid_step'] = true;
        foreach ($data['req'] as $valid) {
            $data['valid_step'] = $data['valid_step'] && $valid;
        }

        Session::put('step2', $data['valid_step']);

        $this->layout->content = View::make('install::step2', $data);
        return $this->layout;
    }

    public function getStep3() {
        if (!Session::get('step2')) {
            return Redirect::to('install/step2');
        }

        Session::put('step3', false);

        $this->layout->step = 3;

        $data = array();

        $this->layout->content = View::make('install::step3', $data);
        return $this->layout;
    }

    public function postCheckdb() {
        if (!Session::get('step2')) {
            return Redirect::to('install/step2');
        }

        $dbhost = Input::get('dbhost');
        $dbuser = Input::get('dbuser');
        $dbpass = Input::get('dbpass');
        $dbname = Input::get('dbname');

        Session::put(array(
            'dbhost' => $dbhost,
            'dbuser' => $dbuser,
            'dbpass' => $dbpass,
            'dbname' => $dbname
        ));

        try {
            $dbh = new pdo("mysql:host={$dbhost};dbname={$dbname}", $dbuser, $dbpass, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

            $sql = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/install/res/dump.sql');

            $result = $dbh->exec($sql);

            $databaseFile = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/install/res/database.php');

            $databaseFile = str_replace(array(
                '{DBHOST}',
                '{DBNAME}',
                '{DBUSER}',
                '{DBPASS}'
                    ), array(
                $dbhost,
                $dbname,
                $dbuser,
                $dbpass
                    ), $databaseFile);

            file_put_contents($_SERVER['DOCUMENT_ROOT'] . '/apps/frontend/config/database.php', $databaseFile);
            file_put_contents($_SERVER['DOCUMENT_ROOT'] . '/apps/backend/config/database.php', $databaseFile);

            Session::put('step3', true);
            return Illuminate\Support\Facades\Redirect::to('install/step4');
        } catch (PDOException $ex) {
            Session::put('step3', false);
            return Illuminate\Support\Facades\Redirect::to('install/step3')->with('conerror', 'Date invalide');
        }
    }

    public function getStep4() {
        if (!Session::get('step3')) {
            return Redirect::to('install/step3');
        }

        Session::put('step4', false);

        $this->layout->step = 4;

        $data = array();

        $this->layout->content = View::make('install::step4', $data);
        return $this->layout;
    }

    public function postChecktpl() {
        if (!Session::get('step3')) {
            return Redirect::to('install/step3');
        }

        $tpl = trim(Input::get('tpl'), './');
        $templatesDir = '/apps/frontend/views/templates/';
        $tempalteDir = $_SERVER['DOCUMENT_ROOT'] . $templatesDir . $tpl;

        if ($tpl && is_dir($tempalteDir)) {

            $templates = glob($_SERVER['DOCUMENT_ROOT'] . $templatesDir . "*", GLOB_ONLYDIR);
            foreach ($templates as $template) {
                if ($tempalteDir != $template) {
                    //File::deleteDirectory($template);
                }
            }

            SettingsModel::put('template_frontend', $tpl);

            Session::put('step4', true);
            return Illuminate\Support\Facades\Redirect::to('install/step5');
        } else {
            Session::put('step4', false);
            return Illuminate\Support\Facades\Redirect::to('install/step4')->with('tplerror', 'Șablon invalid.');
        }
    }

    public function getStep5() {
        if (!Session::get('step4')) {
            return Redirect::to('install/step4');
        }

        Session::put('step5', false);

        $this->layout->step = 5;

        $data = array();

        $this->layout->content = View::make('install::step5', $data);
        return $this->layout;
    }

    public function postCheckadmin() {
        if (!Session::get('step4')) {
            return Redirect::to('install/step4');
        }

        Session::put('step5', false);

        $username = Input::get('username');
        $email = Input::get('email');
        $password = Input::get('password');
        $password2 = Input::get('password2');

        if ($password == $password2) {
            $user = new User;
            $user->username = $username;
            $user->email = $email;
            $user->password = Hash::make($password);
            $user->save();

            $roles = Role::where('on_install', 1)->get();
            foreach ($roles as $role) {
                $urole = new UserRole;
                $urole->user_id = $user->id;
                $urole->role_id = $role->id;
                $urole->save();
            }

            Session::put('step5', true);

            copy($_SERVER['DOCUMENT_ROOT'] . '/install/uninstalled', $_SERVER['DOCUMENT_ROOT'] . '/install/installed');

            return $this->getFinal();
        } else {
            Session::put('step5', false);
            return Illuminate\Support\Facades\Redirect::to('install/step5')->with('uerror', 'Parolele nu coincid');
        }
    }

    public function getFinal() {
        $this->layout->step = 6;

        $data = array();

        $this->layout->content = View::make('install::step6', $data);
        return $this->layout;
    }

    public function getRemove() {
        File::deleteDirectory($_SERVER['DOCUMENT_ROOT'] . "/install");
        return Illuminate\Support\Facades\Redirect::to('/');
    }

}
