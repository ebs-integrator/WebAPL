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
 * */

namespace WebAPL\Modules;

use WebAPL\Actions,
    WebAPL\Template,
    Input,
    NewsletterModel,
    jQgrid,
    Route,
    Event,
    Mail;

class Newsletter extends \WebAPL\ExtensionController {

    protected $module_name = 'newsletter';
    protected $layout;

    public function __construct() {
        parent::__construct();

        $this->loadClass(array('NewsletterModel'));

        Route::get('newsletter/settings', array('before' => 'auth', array($this, 'settings')));
        Route::get('newsletter/list', array('before' => 'auth', array($this, 'email_list')));
        Route::post('newsletter/getlist', array('before' => 'auth', array($this, 'getlist')));
        Route::post('newsletter/edititem', array('before' => 'auth', array($this, 'edititem')));
        Route::get('newsletter/send', array('before' => 'auth', array($this, 'send_message')));
        Route::post('newsletter/sendarticle', array('before' => 'auth', array($this, 'sendarticle')));
        Route::get('newsletter/export', array('before' => 'auth', array($this, 'getExport')));

        Event::listen('construct_left_menu', array($this, 'left_menu_item'));
        Event::listen('feed_post_bottom', array($this, 'sendemails'));

        $this->layout = Template::mainLayout();
    }

    public function settings() {
        $this->layout->content = Template::moduleView($this->module_name, 'views.settings');

        return $this->layout;
    }

    public function left_menu_item() {
        if (\User::has('newsletter-view')) {
            echo Template::moduleView($this->module_name, 'views.newsletter-left-menu');
        }
    }

    public function email_list() {
        \User::onlyHas('newsletter-view');

        $this->layout->content = Template::moduleView($this->module_name, 'views.list');

        return $this->layout;
    }

    public function getlist() {
        \User::onlyHas('newsletter-view');

        $jqgrid = new jQgrid('apl_newsletter');
        echo $jqgrid->populate(function ($start, $limit) {
            return NewsletterModel::select('id', 'email', 'subscribe_date', 'enabled')->skip($start)->take($limit)->get();
        });
    }

    public function edititem() {
        \User::onlyHas('newsletter-view');

        $jqgrid = new jQgrid('apl_newsletter');
        $jqgrid->operation(array(
            'email' => Input::get('email'),
            'enabled' => Input::get('enabled')
        ));
    }

    public function send_message() {
        \User::onlyHas('newsletter-view');

        $this->layout->content = Template::moduleView($this->module_name, 'views.list');

        return $this->layout;
    }

    public function sendemails($post) {
        $data['post'] = $post;

        echo Template::moduleView($this->module_name, 'views.send_email', $data);
    }

    public function sendarticle() {
        $post_id = Input::get('id');

        $post = \PostLang::where('post_id', $post_id)->first();
        if ($post) {

            $data['post'] = $post;
            $data['post_url'] = url("/../" . \WebAPL\Language::ext() . "/topost/" . $post_id);

            Template::viewModule($this->module_name, function () use ($data, $post) {
                $newsletterUsers = \NewsletterModel::where('enabled', 1)->get();

                foreach ($newsletterUsers as $user) {
                    if (filter_var($user->email, FILTER_VALIDATE_EMAIL)) {
                        $data['user'] = $user;
                        $data['unsubscribe_link'] = url("/../newsletter/unsubscribe/{$user->hash}");
                        Mail::send('views.emails.post', $data, function($message) use ($post, $user) {
                            $message->from("noreply@{$_SERVER['SERVER_NAME']}", 'WebLPA');
                            $message->subject($post->title . " :: NEWSLETTER");
                            $message->to($user->email);
                        });
                    }
                }
            });
        }
    }

    public function getExportCSV() {
        \User::onlyHas('newsletter-view');

        $buffer = "";

        $emails = NewsletterModel::all();

        foreach ($emails as $email) {
            $buffer .= "{$email->email}," . ($email->enabled ? 'activ' : 'inactiv') . ",\"{$email->subscribe_date}\"\n";
        }

        header('Content-Encoding: UTF-8');
        header('Content-type: text/csv; charset=UTF-8');
        header('Content-Disposition: attachment; filename=NewsLetterExport.csv');
        echo "\xEF\xBB\xBF" . $buffer;
        die;
    }

    public function getExport() {
        \User::onlyHas('newsletter-view');

        $emails = NewsletterModel::all();

        $matrix = [['Email', 'Status', 'Date']];

        foreach ($emails as $email) {
            $matrix[] = [$email->email, ($email->enabled ? 'activ' : 'inactiv'), $email->subscribe_date];
        }

        $excel = new \ExcelFile('NewsLetterExport.xls');
        $excel->convert($matrix);
    }

}
