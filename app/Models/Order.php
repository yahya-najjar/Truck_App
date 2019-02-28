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

	public static function getRatingsPerStar($star)
	{
		 if($star == 6)
            $ratings = Order::all();
        else
            $ratings = Order::whereRaw('rating = ?', [$star]);
       
         return $ratings;
	}
}
