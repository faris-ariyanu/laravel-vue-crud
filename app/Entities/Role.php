<?php namespace App\Entities;
  
use Illuminate\Database\Eloquent\Model;
  
class Role extends Model
{
    protected $table = 'sys_role';

    public function status()
  	{
    	return $this->belongsTo('App\Entities\Status', 'status');
  	}

  	public function menu()
  	{
    	return $this->hasMany('App\Entities\RoleMenu', 'role_id');
  	}

}

?>