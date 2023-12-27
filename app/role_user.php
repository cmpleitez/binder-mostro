<?php
namespace App;
use Illuminate\Database\Eloquent\Model;

class role_user extends Model
{
	protected $table = 'role_user';
    	protected $guarded = ['id', 'role_id', 'user_id', 'created_at', 'updated_at'];
}
