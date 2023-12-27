<?php
namespace App;
use Illuminate\Database\Eloquent\Model;

class requisition_user extends Model
{
	protected $table = 'requisition_user';
    protected $guarded = ['id', 'user_id', 'requisition_id', 'created_at', 'updated_at'];

	public function requisition()
    {
        return $this->belongsTo('App\Requisition');
    }

    public function branch()
    {
        return $this->belongsTo('App\Branch');
    }

    public function area()
    {
        return $this->belongsTo('App\Area');
    }

	public function user()
    {
        return $this->belongsTo('App\User');
    }
}
