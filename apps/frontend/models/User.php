<?php

class User extends Eloquent {

    use EloquentTrait;

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

    public static function withRole($role) {
        return UserRole::join(Role::getTableName(), Role::getField('id'), '=', UserRole::getField('role_id'))
                ->join(User::getTableName(), User::getField('id'), '=', UserRole::getField('user_id'))
                ->select(User::getField('*'))
                ->where(Role::getField('key'), $role)
                ->get();
    }

}
