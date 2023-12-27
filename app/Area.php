<?php
namespace App;
use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    protected $guarded = ['id', 'email_verified_at', 'password', 'remember_token' ,'active', 'created_at', 'updated_at'];

    public function requisition_user() {
        return $this->hasMany('App\requisition_user');
    }

    public function user()
    {
        return $this->hasMany('App\User');
    }

    public function carts()
    {
        return $this->hasMany('App\Cart');
    }
}
