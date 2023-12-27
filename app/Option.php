<?php
namespace App;
use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    protected $guarded = ['id', 'active', 'created_at', 'updated_at'];
}
