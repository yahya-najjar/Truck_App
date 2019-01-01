<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Auth\Authenticatable as AuthenticableTrait;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use App\Models\Order;


class Customer extends \Eloquent implements Authenticatable ,JWTSubject
{
	use AuthenticableTrait;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $guard = 'customer';
    protected $fillable = [
    	'first_name','last_name','gender','age','type', 'phone','email', 'password', 'is_verified','code','platform','FCM_Token','payment_type','truck_id'
    ];

    const DRIVER = 2;
    const CUSTOMER = 1;

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
    	'password', 'remember_token',
    ];

    public function getJWTIdentifier()
    {
    	return $this->getKey();
    }
    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
    	return [];
    }

    public static function drivers(){
        return Customer::where('type',2);
    }

    public function roles(){
        return null;
    }

    public function getFullNameAttribute()
    {
        return $this->first_name . " " . $this->last_name ;
    }

    public function orders()
    {
        return $this->hasMany(Models\Order::class);
    }

    public function pending_orders(){
        // $orders = Order::join('')
        $orders = Order::where('status',1)->get();
        return $orders;
    }

    public function completed_orders(){
        $orders = Order::where('status',2)->get();
        return $orders;
    }

    public function canceled_orders(){
        $orders = Order::where('status',0)->get();
        return $orders;
    }
}
