<?php

namespace WebAPL\Modules;


use Illuminate\Support\Facades\Event;


use WebAPL\Actions,
    Template,
    Files,
    Route;


class Partners extends \WebAPL\ExtensionController
{
    protected $module_name = 'partners';

    public function __construct()
    {
        parent::__construct();

        Event::listen('home_right_partners', array($this, 'page_bottom_partners'));

    }

    public function page_bottom_partners()
    {
        $file = Files::file_lister('partners_logo', 1);
        if (count($file)) {
            echo Template::moduleView($this->module_name, 'views.partners', [
                'list' => $file

            ]);
        }
    }

}