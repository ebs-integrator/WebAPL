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
        $this->layout->content = View::make('sections.user.list', $this->data);

        return $this->layout;
    }

    public function postLists() {
        $jqgrid = new jQgrid(User::getTableName());
        return $jqgrid->populate(function ($start, $limit) {
                    return User::select(User::getField('id'), User::getField('username'), User::getField('email'))
                                    ->skip($start)
                                    ->take($limit)
                                    ->get();
                });
    }

    public function getView($id) {
        $this->data['user'] = User::find($id);
        $this->data['roles'] = Role::all();
        
        if ($this->data['user']) {
            $this->layout->content = View::make('sections.user.view', $this->data);

            return $this->layout;
        } else {
            throw new Exception("User not found");
        }
    }

    public function postSaveroles() {
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

}
