<?php
namespace App;
use Illuminate\Database\Eloquent\Model;

class offer_service extends Model
{
	protected $table = 'offer_service';
    	protected $guarded = ['id', 'offer_id', 'service_id', 'created_at', 'updated_at'];
}
