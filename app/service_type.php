<?php
namespace App;
use Illuminate\Database\Eloquent\Model;

class service_type extends Model
{
    protected $guarded = ['id', 'type', 'icon', 'active', 'created_at', 'updated_at'];

	public function service() {
		return $this->hasMany('App\Service');
	}

}
