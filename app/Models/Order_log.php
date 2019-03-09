<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order_log extends Model
{
	protected $fillable = ['status','order_id','lat','lng','kilometrage','location'];

	public function order()
	{
		return $this->belongsTo(Order::class);
	}

	public function getColorAttribute()
	{
		switch ($this->status) {
			case Order::PENDING:
				return '#FFFF00';
			break;
			case Order::ACCEPTED:
				return '#61d8c2';
			break;
			case Order::ARRIVED:
				return '#64d861';
			break;
			case Order::DONE:
				return '#7661d8';
			break;
			case Order::CANCELED:
			case Order::REJECTED:
				return '#e01802';
			break;
			default:
				return '#FFF';
			break;
		}
	}

	public function getStatusNameAttribute()
	{
		switch ($this->status) {
			case Order::PENDING:
			return 'PENDING';
			break;
			case Order::ACCEPTED:
			return 'ACCEPTED';
			break;
			case Order::ARRIVED:
			return 'ARRIVED';
			break;
			case Order::DONE:
			return 'DONE';
			break;
			case Order::REJECTED:
			return 'REJECTED';
			case Order::CANCELED:
			return 'CANCELED';
		}
	}
}
