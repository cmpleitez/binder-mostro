<?php
namespace App;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
	protected $guarded = ['id', 'active', 'created_at', 'updated_at'];

	public function requisition()
    {
        return $this->hasMany('App\Requisition');
    }

    public function service() {
    	return $this->belongsTomany('App\Service')->withTimestamps();
    }
}
