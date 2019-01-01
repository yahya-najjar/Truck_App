<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\User;

class Supplier extends Model
{
	

	protected $fillable = [
		'name', 'phone', 'description','location','expire_date','user_id'
	];

	public function truck(){
		return $this->hasMany(Truck::class);
	}

	public function user(){
		return $this->belongsTo(User::class);
	}
	public function bills(){
		return $this->hasMany(Bill::class);
	}

	public function getIsExpiredAttribute()
	{
		$sup_date = Carbon::parse($this->expire_date);
		if($sup_date->gt(Carbon::now()))
			return false;

		return true;
	}

}