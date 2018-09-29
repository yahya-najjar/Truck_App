<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
	protected $fillable = ['location','lat','lng','status','rating','user_id','truck_id'];

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function truck()
	{
		return $this->belongsTo(Truck::class);
	}
}
