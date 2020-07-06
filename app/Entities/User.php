<?php namespace App\Entities;
  
use Illuminate\Database\Eloquent\Model;
  
class User extends Model
{
    protected $table = 'sys_users';

    public function status()
  	{
    	return $this->belongsTo('App\Entities\Status', 'status');
  	}

  	public function role()
  	{
    	return $this->belongsTo('App\Entities\Role', 'role_id');
  	}

}

?>