<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

use App\requisition_user;
use App\Notifications\ResetPassword;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    protected $guarded = ['id', 'branch_id', 'section_id', 'cashbox_id', 'email_verified_at', 'autoservicio', 'active' , 'created_at', 'updated_at'];

    protected $hidden = [
        'password', 'remember_token'
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function scopeSearch($query, $search) {
        return $query->where('id', '<>', 1)->where('name','like','%'.$search.'%')->orWhere('dui','like','%'.$search.'%')->orWhere('phone_number','like','%'.$search.'%');
    }

    public function cart()
    {
        return $this->hasMany('App\Cart', 'id', 'client_id');
    }

    public function requisition() {
        return $this->belongsTomany('App\Requisition')->as('task')->withPivot('processed', 'inspected', 'active')->withTimestamps();
    }

    public function role()
    {
        return $this->belongsToMany('App\Role')->withTimestamps();
    }

    public function branch()
    {
        return $this->belongsTo('App\Branch');
    }

    public function area()
    {
        return $this->belongsTo('App\Area');
    }

    public function gatheredMenu()
    {
        $menu = User::with(['role.service' => function($query) {
            $query->where('menu', true);
        }])->where('id', auth()->user()->id)->where('active', true)->first();
        return $menu;
    }

    public function profile(){
        return User::with('branch')->with('area')->first();
    }

    public function cashbox()
    {
        return $this->hasOne('App\cashbox');
    }

    public function square(){
        return $this->hasMany('App\Square');
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }

}
