<?php
namespace App;
use Illuminate\Database\Eloquent\Model;

class Cashbox extends Model
{
    protected $guarded = ['id','active', 'created_at', 'updated_at'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
