<?php

/**
 *
 *
 * @author     Godina Nicolae <ngodina@ebs.md>
 * @copyright  2014 Enterprise Business Solutions SRL
 * @link       http://ebs.md/
 */
class UserController extends BaseController {

    function __construct() {
        parent::__construct();

        $this->beforeFilter(function() {
            if (!Auth::check()) {
                return Redirect::to('auth');
            }
        });
    }

    protected $layout = 'layout.main';

    public function getIndex() {
        User::onlyHas('user-view');
        
        $this->layout->content = View::make('sections.user.list', $this->data);

        return $this->layout;
    }

    public function postCreate() {
        User::onlyHas('user-create');
        
        $user = new User;
        $user->username = Input::get('username');
        $user->email = Input::get('email');
        $user->password = Hash::make(Input::get('password'));
        $user->save();

        return Illuminate\Support\Facades\Redirect::to('user/view/' . $user->id);
    }

    public function postLists() {
        User::onlyHas('user-view');
        
        $jqgrid = new jQgrid(User::getTableName());
        return $jqgrid->populate(function ($start, $limit) {
                    return User::select(User::getField('id'), User::getField('username'), User::getField('email'))
                                    ->skip($start)
                                    ->take($limit)
                                    ->get();
                });
    }

    public function getView($id) {
        User::onlyHas('user-edit');
        
        $this->data['user'] = User::find($id);
        $this->data['roles'] = Role::orderBy('key', 'asc')->get();

        if ($this->data['user']) {
            $this->layout->content = View::make('sections.user.view', $this->data);

            return $this->layout;
        } else {
            throw new Exception("User not found");
        }
    }

    public function postSaveroles() {
        User::onlyHas('user-roles');
        
        $id = Input::get('id');
        $roles = Input::get('roles');

        UserRole::where('user_id', $id)->delete();
        if (is_array($roles)) {
            foreach ($roles as $role_id) {
                $item = new UserRole;
                $item->role_id = $role_id;
                $item->user_id = $id;
                $item->save();
            }
        }

        return [];
    }
    
    public function postSave() {
        User::onlyHas('user-edit');
        
        $user = User::find(Input::get('id'));
        $user->username = Input::get('username');
        $user->email = Input::get('email');
        $user->save();
        return [];
    }
    
    public function postChangepassword() {
        User::onlyHas('user-chpwd');
        
        $password = trim(Input::get('password'));
        if ($password) {
            
            $user = User::find(Input::get('id'));
            $user->password = Hash::make($password);
            $user->save();
            
        }
        
        return [];
    }

}
