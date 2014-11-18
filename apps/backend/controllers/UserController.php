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
  **/
 
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

        Log::info('Create user: ' . Input::get('username'));

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
        $uid = Input::get('id');

        $uroles = User::extractRoles($uid);

        if ((User::has('user-roles') && (!User::has('user-ptroles', $uroles) || $uid == Auth::user()->id)) == FALSE) {
            throw new Exception("Access denied;");
        }

        $id = Input::get('id');
        $roles = Input::get('roles');

        Log::info('Change roles user#' . $id);

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

        Log::info('Change user ' . Input::get('username'));

        $user = User::find(Input::get('id'));
        $user->username = Input::get('username');
        $user->email = Input::get('email');
        $user->save();
        return [];
    }

    public function postChangepassword() {
        $uid = Input::get('id');

        $uroles = User::extractRoles($uid);

        if (((User::has('user-chpwd') && (!User::has('user-ptpsw', $uroles))) || $uid == Auth::user()->id) == FALSE) {
            throw new Exception("Access denied;");
        }

        $password = trim(Input::get('password'));
        if ($password) {

            $user = User::find($uid);
            $user->password = Hash::make($password);
            $user->save();
        }

        Log::info('Change password #' . Input::get('id'));

        return [];
    }

    public function postDelete() {
        User::onlyHas('user-delete');

        $id = Input::get('id');

        $user = User::find($id);
        if ($user) {
            $user->delete();
            UserRole::where('user_id', $id)->delete();

            Log::info('Delete user #' . $id);

            return \Illuminate\Support\Facades\Redirect::to('user');
        } else {
            throw new Exception("Undefined user #{$id}");
        }
    }

}
