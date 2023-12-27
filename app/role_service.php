<?php
namespace App;
use Illuminate\Database\Eloquent\Model;

class role_service extends Model
{
	protected $table = 'role_service';
    	protected $guarded = ['id', 'created_at', 'updated_at'];
    	//'role_id', 'service_id'
}
