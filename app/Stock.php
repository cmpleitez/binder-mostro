<?php
namespace App;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    protected $guarded = ['id', 'branch_id', 'service_id', 'minimum_quantity', 'active','created_at', 'updated_at'];
    
    public function branch()
    {
        return $this->belongsTo('App\Branch');
    }
    
    public function service()
    {
        return $this->belongsTo('App\Service');
    }
}
