<?php
namespace App;
use Illuminate\Database\Eloquent\Model;

class branch_service extends Model
{
    protected $table = 'branch_service';
    protected $guarded = ['id', 'banch_id', 'service_id', 'stock_quantity', 'minimum_quantity', 'active','created_at', 'updated_at'];
    
    public function branch()
    {
        return $this->belongsTo('App\Branch');
    }

    public function service()
    {
        return $this->belongsTo('App\Service');
    }
}