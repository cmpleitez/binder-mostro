<?php
namespace App;
use Illuminate\Database\Eloquent\Model;

class Square extends Model
{
    protected $guarded = ['id','created_at', 'updated_at'];

    public function cart()
    {
        return $this->hasMany('App\Cart');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
