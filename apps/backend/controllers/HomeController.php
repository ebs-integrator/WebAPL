<?php

class HomeController extends BaseController {

    function __construct() {
        parent::__construct();

        $this->beforeFilter(function() {
            if (!Auth::check()) {
                return Redirect::to('auth');
            }
        });
    }

    protected $layout = 'layout.main';

    public function postLangs() {
        $jqgrid = new jQgrid('apl_lang');
        echo $jqgrid->populate(function ($start, $limit) {
            return DB::table('apl_lang')->get();
        });
        $this->layout = null;
    }
    
    public function postEditlang() {
        $jqgrid = new jQgrid('apl_lang');
        $jqgrid->operation(array(
            'name' => Input::get('name'),
            'ext' => Input::get('ext'),
            'enabled' => Input::get('enabled')
        ));
        
        $this->layout = null;
    }
    
    public function showDashboard() {
        $this->layout->content = View::make('hello');
    }
    
    public function getLanguages() {
        $this->layout->content = View::make('sections.language.list');
    }

    public function showPage() {
        echo 'test backend';
    }

}
