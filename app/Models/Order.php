<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Customer;

class Order extends Model
{
	protected $fillable = ['location','lat','lng','status','rating','customer_id','comment','truck_id'];

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

	// public function getAllLocations(){                                
	// 	$locs = $this->locations()->get();
	// 	$roads= array();
	// 	$roads = $this->calc_roads($locs);
	// 	return array_sum($roads);
	// }

	// public function calc_roads($locs){
	// 	$roads = array();
	// 	$temp = sizeof($locs);
	// 	for($i=0;$i< sizeof($locs);$i+=2){
	// 		$start = $locs[$i];

	// 		if(($temp % 2) && ($i==$temp-1))
	// 			$end = $locs[$i];
	// 		else
	// 			$end = $locs[$i+1];

	// 		if($start)
	// 			if($end){
	// 				$road =$this->distance($start->lat,$start->lng,$end->lat,$end->lng,"K");
 //                    // return $off;
	// 				if(is_nan($road)) $roads[$i] = 0;
	// 				else
	// 					$roads[$i] = $road;
	// 			}
	// 		}

	// 		return $roads;
	// 	}

	// 	function distance($lat1, $lon1, $lat2, $lon2, $unit) {

	// 		$theta = $lon1 - $lon2;
	// 		$dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
	// 		$dist = acos($dist);
	// 		$dist = rad2deg($dist);
	// 		$miles = $dist * 60 * 1.1515;
	// 		$unit = strtoupper($unit);

	// 		if ($unit == "K") {
	// 			return ($miles * 1.609344);
	// 		} else if ($unit == "N") {
	// 			return ($miles * 0.8684);
	// 		} else {
	// 			return $miles;
	// 		}
	// 	}
	}
