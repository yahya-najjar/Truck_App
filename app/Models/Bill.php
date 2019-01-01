<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{

	protected $fillable = [
		'cash_amount', 'month_count', 'note','transaction_id','supplier_id','truck_id','payment_type'
	];

	public function supplier(){
		return $this->belongsTo(Supplier::class);
	}
	public function truck(){
		return $this->belongsTo(Truck::class);
	}
}
