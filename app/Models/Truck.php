<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
use Carbon\Carbon;
use App\Customer;

class Truck extends Model
{
	protected $fillable = [
		'driver_name', 'plate_num', 'location','desc','capacity','model','driver_phone','company_phone','status','supplier_id','price_km','price_h','lat','lng','rating','image','distances','expire_date','licence_date','driver_id'
	];

	const OFFLINE = 0;  
	const ONLINE = 1;  
	const BUSY = 2;  
	const ONREQUEST = 3;  


	public function supplier()
	{
		return $this->belongsTo(Supplier::class);
	}

	public function currentDriver()
	{
		return $this->belongsTo(Customer::class,'driver_id');
	}

	public function orders()
	{
		return $this->hasMany(Order::class);
	}

	public function accepted_orders()
	{
		return $this->orders()->where('status',Order::ACCEPTED);
	}

	public function rejected_orders()
	{
		return $this->orders()->where('status',Order::REJECTED);
	}

	public function arrived_orders()
	{
		return $this->orders()->where('status',Order::ARRIVED);
	}

	public function done_orders()
	{
		return $this->orders()->where('status',Order::DONE);
	}

	public function canceled_orders()
	{
		return $this->orders()->where('status',Order::CANCELED);
	}

	public function ongoing_orders()
	{
		return $this->orders()->whereIn('status',[Order::PENDING,Order::ACCEPTED,Order::ARRIVED]);
	}

	public function pendingOrder(){

		return $this->orders()->with('customer')->whereIn('status',[Order::PENDING,Order::ACCEPTED,Order::ARRIVED])->latest()->first();
	}

	public function bills()
	{
		return $this->hasMany(Bill::class);	
	}

	public function getIsOnlineAttribute(){                   
		return DB::table('truck_logs')
		->where('truck_id',$this->id)
		->latest()->first();
	}  

	public function truck_logs()
	{
		return $this->hasMany(Truck_log::class);	
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

	public function getLicenceIsExpiredAttribute()
	{
		$sup_date = Carbon::parse($this->licence_date);
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

	public function customers()
    {
        return $this->belongsToMany(\App\Customer::class)->withPivot('from','to','date','hours','note')->withTimestamps();   
    }

	public function getImageAttribute()
    {
        return  action('ImageController@show', $this->attributes['image']);
    }

    public function getStatusNameAttribute()
    {
    	switch ($this->status) {
    		case 0:
    			return 'OFFLINE';
    			break;
    		case 1:
    			return 'ONLINE';
    			break;
			case 2:
    			return 'BUSY';
    			break;
			case 3:
    			return 'ONREQUEST';
    			break;
    	}
    }

    public function truck_shifts()
    {
    	$truck_id = $this->id;
    	$shifts = DB::table('customer_truck')
    	            ->join('customers', function ($join) use ($truck_id) {
    	                $join->on('customer_truck.customer_id', '=', 'customers.id')
    	                     ->where('customer_truck.truck_id', '=', $truck_id);
    	            })
    	            ->select('customer_truck.*','customers.*')
    	            ->get();

    	return $shifts;

	}
}
