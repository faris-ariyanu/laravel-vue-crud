<?php namespace App\Entities;
  
use Illuminate\Database\Eloquent\Model;
  
class Status extends Model
{
    protected $table = 'sys_status';
    
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at',
    ];
}

?>