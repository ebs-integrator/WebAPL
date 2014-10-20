<?php

class AuthController extends BaseController {

    protected $layout = 'layout/login';

    public function getIndex() {
    }

    public function postTake() {
        $capcha = Input::get('capcha');
        if (SimpleCapcha::valid('login_admin', $capcha) === false) {
            return Redirect::intended('auth/index')->with('auth_error', 'Invalid Capcha');
        }
        
        if (Auth::attempt(array('username' => Input::get('username'), 'password' => Input::get('password')))) {
            Log::info('User login');
            return Redirect::intended('/');
        } else {
            return Redirect::intended('auth/index')->with('auth_error', 'Invalid Username or Password');
        }
    }
    
    public function getLogout() {
        Log::info('User logout');
        Auth::logout();
    }

}
