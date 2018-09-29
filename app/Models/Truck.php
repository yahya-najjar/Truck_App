<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Truck extends Model
{
    	protected $fillable = [
		'driver_name', 'plate_num', 'location','capacity','model','driver_phone','company_phone','status','supplier_id','price_km','price_h','lat','lng'
	];	


	 public function supplier(){
    	return $this->belongsTo(Supplier::class);
    }

    public function orders(){
    	return $this->hasMany(Order::class);
    }	
}
