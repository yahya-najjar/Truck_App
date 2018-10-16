<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Auth\Authenticatable as AuthenticableTrait;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;


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
    	'first_name','last_name','gender','age','type', 'phone','email', 'password', 'is_verified','code','platform','FCM_Token','payment_type'
    ];

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

    public function truck()
    {
        return $this->belongsTo(Truck::class);
    }

    public static function drivers(){
        return Customer::where('type',2);
    }
}
