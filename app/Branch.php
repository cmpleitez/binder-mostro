<?php
namespace App;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    protected $guarded = ['id', 'active', 'created_at', 'updated_at'];

    public function requisition_user() {
        return $this->hasMany('App\requisition_user');
    }

    public function user() {
        return $this->hasMany('App\User');
    }

    public function service() {
        return $this->belongsTomany('App\Service')->withPivot('cost', 'supplied_quantity', 'stock_quantity', 'minimum_quantity', 'active')->withTimestamps();
    }
}