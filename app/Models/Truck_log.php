<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Truck_log extends Model
{
	protected $fillable = ['online','truck_id'];

	public function truck()
	{
		return $this->belongsTo(Truck::class);
	}
}