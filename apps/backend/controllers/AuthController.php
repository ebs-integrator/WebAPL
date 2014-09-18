<?php

class AuthController extends BaseController {

    protected $layout = 'layout/login';

    public function getIndex() {
    }

    public function postTake() {
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
