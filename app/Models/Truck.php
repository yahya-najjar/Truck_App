<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
use Carbon\Carbon;

class Truck extends Model
{
	protected $fillable = [
		'driver_name', 'plate_num', 'location','capacity','model','driver_phone','company_phone','status','supplier_id','price_km','price_h','lat','lng','rating','distances'
	];  


	public function supplier()
	{
		return $this->belongsTo(Supplier::class);
	}

	public function orders()
	{
		return $this->hasMany(Order::class);
	}

	public function bills()
	{
		return $this->hasMany(Bill::class);	
	}

	public function customers()
	{
		return $this->hasMany(Customer::class);
	}

	public function getIsOnlineAttribute(){                   
		return DB::table('truck_logs')
		->where('truck_id',$this->id)
		->latest()->first();
	}  

	public function truck_logs()
	{
		return $this->hasMany(Bill::class);	
	}

	public function getRatingAvgAttribute()
	{
		$rates = DB::table('orders')
		->where('truck_id', $this->id)
		->avg('rating');

		return $rates;
	}

	public static function PrivateTrucks()
	{
		$trucks=Truck::whereNull('supplier_id')->get();
		return $trucks;
		
	}

	public function getIsExpiredAttribute()
	{
		$sup_date = Carbon::parse($this->expire_date);
		if($sup_date->gt(Carbon::now()))
			return false;

		return true;
	}

	public  function distance($lat2, $lon2, $unit) {
		$lat1 = $this->lat;
		$lon1 = $this->lng;
		$theta = $lon1 - $lon2;
		$dist = acos(cos(deg2rad(90-$lat1)) *cos(deg2rad(90-$lat2)) +sin(deg2rad(90-$lat1)) *sin(deg2rad(90-$lat2)) *cos(deg2rad($lon1-$lon2))) *6371;
		$miles = $dist * 60 * 1.1515;
		$unit = strtoupper($unit);
		// return $dist;

		if ($unit == "K") {
			return ($miles * 1.609344);
		} else if ($unit == "N") {
			return ($miles * 0.8684);
		} else {
			return $miles;
		}
	}

}
