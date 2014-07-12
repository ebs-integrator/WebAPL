<?php

class AuthController extends BaseController {

    protected $layout = 'layout/login';

    public function getIndex() {
    }

    public function postTake() {
        if (Auth::attempt(array('username' => Input::get('username'), 'password' => Input::get('password')))) {
            return Redirect::intended('/');
        } else {
            return Redirect::intended('auth/index')->with('auth_error', 'Invalid Username or Password');
        }
    }
    
    public function getLogout() {
        Auth::logout();
    }

}
