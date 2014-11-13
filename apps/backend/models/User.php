<?php

/**
 * 
 * CMS WebAPL 1.0. Platform is a free open source software for creating an managing
 * their full with CMS integrated CMS system
 * 
 * Copyright (C) 2014 Enterprise Business Solutions SRL
 * 
 * This program is free software: you can redistribute it and/or modify it under
 * the terms of the GNU General Public License as published by the Free Software
 * Foundation, either version 3 of the License, or any later version.
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A
 * PARTICULAR PURPOSE. See the GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License along with
 * this program.  If not, see <http://www.gnu.org/licenses/>.
 * You can read the copy of GNU General Public License in english here 
 * 
 * For more details about CMS WebAPL 1.0 please contact Enterprise Business
 * Solutions SRL, Republic of Moldova, MD 2001, Ion Inculet 33 Street or send an
 * email to office@ebs.md 
 * 
 */
use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

    use UserTrait,
        EloquentTrait,
        RemindableTrait;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'apl_user';
    public $timestamps = false;

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = array('password');
    protected static $roles = array();

    public static function extractRoles($user_id) {
        $roles = UserRole::join(Role::getTableName(), Role::getField('id'), '=', UserRole::getField('role_id'))
                ->select(Role::getField('*'))
                ->where(UserRole::getField('user_id'), $user_id)
                ->get();

        $list = array();
        
        foreach ($roles as $role) {
            $list[] = $role->key;
        }
        
        return $list;
    }

    public static function roles() {
        if (empty(static::$roles)) {
            static::$roles = User::extractRoles(Auth::user()->id);
        }
        return static::$roles;
    }

    public static function has($role, $roles = 0) {
        if ($roles === 0) {
            $roles = User::roles();
        }
                
        return in_array($role, $roles);
    }
    
    public static function onlyHas($role) {
        if (!User::has($role))
            throw new Exception("Access denied!");
    }
    
    public static function withRole($role) {
        return UserRole::join(Role::getTableName(), Role::getField('id'), '=', UserRole::getField('role_id'))
                ->join(User::getTableName(), User::getField('id'), '=', UserRole::getField('user_id'))
                ->select(User::getField('*'))
                ->where(Role::getField('key'), $role)
                ->get();
    }

}
