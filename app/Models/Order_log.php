<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order_log extends Model
{
    protected $fillable = ['status','order_id','lat','lng','kilometrage'];

	public function order()
	{
		return $this->belongsTo(Order::class);
	}
}
