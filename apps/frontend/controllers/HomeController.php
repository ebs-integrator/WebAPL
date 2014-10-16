<?php

class HomeController extends BaseController {
    /*
      |--------------------------------------------------------------------------
      | Default Home Controller
      |--------------------------------------------------------------------------
      |
      | You may wish to use controllers instead of, or in addition to, Closure
      | based routes. That's great! Here is an example controller method to
      | get you started. To route to this controller, just add the route:
      |
      |	Route::get('/', 'HomeController@showWelcome');
      |
     */

    protected $layout = 'layout/home';

    public function showWelcome() {
        $this->layout->content = View::make('pages/hello');
        $this->layout->testvar = 'asd';
        echo url('/myurl');
        //return Redirect::to('user/1');
        $this->layout = null;
    }

    public function home_markup($view) {
        $this->layout = 'layout/html_home';
        $this->setupLayout();
        
        $this->layout->content = View::make('markup/' . $view);

        return $this->layout;
    }

    public function page_markup($view) {
        $this->layout = 'layout/html_page';
        $this->setupLayout();
        
        $this->layout->content = View::make('markup/' . $view);

        return $this->layout;
    }
    
    public function clearcache() {
        Cache::flush();
        
        return [];
    }

}
