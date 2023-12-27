<?php
namespace App;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
	protected $guarded = ['id', 'active', 'created_at', 'updated_at'];

	public function authorization() {
	  return $this->hasMany('App\Authorization');
	}

    public function user() {
        return $this->belongsToMany('App\User')->withTimestamps();
    }

    public function service() {
    	return $this->belongsTomany('App\Service')->withTimestamps();
    }
}
