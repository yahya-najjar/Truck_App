<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Customer;

class Order extends Model
{
	protected $fillable = ['location','lat','lng','status','rating','customer_id','comment','truck_id','driver_id'];

	const PENDING = 0;  
	const ACCEPTED = 1;
	const ARRIVED = 2;  
	const DONE = 3;  
	const REJECTED = -1;
	const CANCELED = -2;

	public static function states()
	{
		$consts = ['PENDING' => 0,'ACCEPTED' => 1,'ARRIVED'=>2,'DONE'=>3,'REJECTED'=>-1,'CANCELED'=>-2];
		return $consts;
	}

	public function customer()
	{
		return $this->belongsTo(Customer::class);
	}

	public function driver()
	{
		return $this->belongsTo(Customer::class,'driver_id');
	}

	public function truck()
	{
		return $this->belongsTo(Truck::class);
	}

	public function order_logs()
	{
		return $this->hasMany(Order_log::class);
	}

	public static function getRatingsPerStar($star)
	{
		if($star == 6)
			$ratings = Order::all();
		else
			$ratings = Order::whereRaw('rating = ?', [$star]);

		return $ratings;
	}

	public function Count($status)
	{
		return Order::where('status',$status)->get()->count();
	}

	public static function OngoingCount()
	{
		return Order::whereIn('status',[Order::PENDING,Order::ACCEPTED,Order::ARRIVED])->get()->count();
	}

	public static function DoneCount()
	{
		return Order::where('status',Order::DONE)->get()->count();
	}

	public static function CancelCount()
	{
		return Order::where('status',Order::CANCELED)->get()->count();
	}

	public static function RejectCount()
	{
		return Order::where('status',Order::REJECTED)->get()->count();
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
