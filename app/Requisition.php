<?php
namespace App;
use Illuminate\Database\Eloquent\Model;

class Requisition extends Model
{
    protected $guarded = ['id', 'processing', 'active', 'created_at', 'updated_at'];

	public function cart()
    {
        return $this->belongsTo('App\Cart');
    }

    public function scopeSearch($query, $search){
        return $query->where('cart_id','like','%'.$search.'%')->where('active', true);
    }

    public function user() {
        return $this->belongsTomany('App\User')->as('incidence')->withPivot('processed', 'inspected')->withTimestamps();
    }

	public function offer()
    {
        return $this->belongsTo('App\Offer');
    }

    public function service()
    {
        return $this->belongsTo('App\Service');
    }

    public function requisition_user() {
        return $this->hasMany('App\requisition_user');
    }
}
