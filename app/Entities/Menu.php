<?php namespace App\Entities;
  
use Illuminate\Database\Eloquent\Model;
  
class Menu extends Model
{
    protected $table = 'sys_menu';

    public function status()
  	{
    	return $this->belongsTo('App\Entities\Status', 'status');
  	}

}

?>