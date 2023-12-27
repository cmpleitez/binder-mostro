<?php
namespace App;
use Illuminate\Database\Eloquent\Model;

class Payment_type extends Model
{
    protected $guarded = ['id', 'active', 'created_at', 'updated_at'];

    public function cart() {
        return $this->hasMany('App\Cart');
    }
}
