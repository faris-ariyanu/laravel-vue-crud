<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $table = 'sys_users';

    use Notifiable;

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public static function getMenuUser($id,$parent=0){
        return $Query = self::join("sys_role","sys_users.role_id","=","sys_role.id")
                            ->join("sys_role_menu","sys_role.id","=","sys_role_menu.role_id")
                            ->join("sys_menu","sys_role_menu.menu_id","=","sys_menu.id")
                            ->where("sys_role.status",1)
                            ->where("sys_menu.status",1)
                            ->where("sys_menu.parent",$parent)
                            ->where("sys_users.id",$id)
                            ->orderBy("sys_menu.sequence","asc")
                            ->select("sys_menu.id","sys_menu.name","sys_menu.url","sys_menu.menu_value")
                            ->get();
    }
}
