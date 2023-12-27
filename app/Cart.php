<?php
namespace App;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $guarded = ['id', 'processing', 'active', 'created_at', 'updated_at'];

	public function branch() {
        return $this->belongsTo('App\Branch');
    }

    public function requisition()
    {
        return $this->hasMany('App\Requisition');
    }

    public function client()
    {
        return $this->belongsTo('App\User', 'client_id', 'id');
    }

    public function payment_type()
    {
        return $this->belongsTo('App\Payment_type');
    }

    public function square()
    {
        return $this->belongsTo('App\Square');
    }
    
}
