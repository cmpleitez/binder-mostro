<?php
namespace App;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
	protected $guarded = ['id', 'active', 'created_at', 'updated_at'];

    public function scopeSearch($query, $search){
        return $query->Where('service','like','%'.$search.'%')->orWhere('id','like','%'.$search.'%');
    }

	public function requisition()
    {
        return $this->hasMany('App\Requisition');
    }

    public function role() {
    	return $this->belongsTomany('App\Role')->withTimestamps();
    }

    public function offer() {
    	return $this->belongsTomany('App\Offer')->withTimestamps();
    }

    public function service_type()
    {
        return $this->belongsTo('App\service_type');
    }

    public function branch() {
        return $this->belongsTomany('App\Branch')->withPivot('cost', 'supplied_quantity', 'stock_quantity', 'minimum_quantity', 'active')->withTimestamps();
    }

    public function stock() {
        return $this->hasOne('App\Stock');
    }

}
