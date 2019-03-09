<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Auth\Authenticatable as AuthenticableTrait;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use App\Models\Order;
use App\Models\Truck;
use DB;

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
    	'first_name','last_name','gender','dob','type', 'phone','email', 'password', 'is_verified','code','platform','FCM_Token','payment_type','truck_id'
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

    // for client
    public function orders()
    {
        return $this->hasMany(Models\Order::class);
    }

    public function orders_driver()
    {
        return $this->hasMany(Models\Order::class,'driver_id');
    }

    public function driver_orderss($status)
    {
        switch ($status) {
            case Order::ACCEPTED:
                return $this->orders_driver()->with('truck')->where('status',Order::ACCEPTED);
                break;
            case Order::REJECTED:
                return $this->orders_driver()->with('truck')->where('status',Order::REJECTED);
                break;
            case Order::DONE:
                return $this->orders_driver()->with('truck')->where('status',Order::DONE);;
                break;
            case Order::PENDING:
                return $this->orders_driver()->with('truck')->where('status',Order::PENDING);
                break;
            case Order::ARRIVED:
                return $this->orders_driver()->with('truck')->where('status',Order::ARRIVED);
                break;
            case Order::CANCELED:
                return $this->orders_driver()->with('truck')->where('status',Order::CANCELED);
                break;
            default:
                return $this->orders_driver()->with('truck','customer');
                break;
        }
    }
    public function driver_orders($status)
    {
        switch ($status) {
            case Order::ACCEPTED:
            case Order::REJECTED:
            case Order::DONE:
            case Order::PENDING:
            case Order::ARRIVED:
            case Order::CANCELED:
                return $this->DriverOrders($status);
                break;
            default:
                return $this->DriverOrders(-5);
                break;
        }
    }

    public function DriverOrders($status)
    {
        $orders = DB::table('orders')->where('orders.driver_id','=',$this->id);
        if ($status != -5) {
            $orders->where('orders.status','=',$status);
        }
        $orders->join('order_logs',function ($join){
                    $join->on('order_logs.order_id','=','orders.id')
                    ->where('order_logs.status',Order::ACCEPTED);
                    })
                    ->join('trucks',function ($query)
                    {
                        $query->on('orders.truck_id','=','trucks.id');
                    })
                    ->join('customers',function ($query)
                    {
                        $query->on('orders.customer_id','=','customers.id');
                    })
                    ->select('orders.*','order_logs.location as location_from','orders.location as location_to','trucks.location as location_current','order_logs.lat as lat_from','order_logs.lng as lng_from','orders.lat as lat_to','orders.lng as lng_to','trucks.lat as lat_current','trucks.lng as lng_current','trucks.driver_name as current_driver','trucks.plate_num','trucks.desc','trucks.lat as truck_lat','trucks.lng as truck_lng','trucks.status as truck_status','trucks.image','orders.status as order_status',DB::raw('CONCAT(first_name, " ", last_name) AS customer_name'),'customers.email as customer_email','customers.phone as customer_phone');

        return $orders;
    }

    // for driver --- Each Truck with it orders
    // public function all_orders($status)
    // {
    //     $trucks_ids = $this->shifts()->pluck('truck_id');
    //     switch ($status) {
    //         case Order::ACCEPTED:
    //             $trucks = Truck::with('accepted_orders')->whereIn('id',$trucks_ids);
    //             break;
    //         case Order::REJECTED:
    //             $trucks = Truck::with('rejected_orders')->whereIn('id',$trucks_ids);
    //             break;
    //         case Order::ARRIVED:
    //             $trucks = Truck::with('arrived_orders')->whereIn('id',$trucks_ids);
    //             break;
    //         case Order::DONE:
    //             $trucks = Truck::with('done_orders')->whereIn('id',$trucks_ids);
    //             break;
    //         case Order::PENDING:
    //             $trucks = Truck::with('pendingOrder')->whereIn('id',$trucks_ids);
    //             break;
    //         default:
    //             $trucks = Truck::with('orders')->whereIn('id',$trucks_ids);
    //             break;
    //     }
    //     return $trucks;
    // }

    public function customer_orders($status)
    {
        switch ($status) {
            case Order::ACCEPTED:
            case Order::REJECTED:
            case Order::DONE:
            case Order::PENDING:
            case Order::ARRIVED:
            case Order::CANCELED:
                return $this->CustomerOrders($status);
                break;
            default:
                return $this->CustomerOrders(-5);
                break;
        }
    }

    public function CustomerOrders($status)
    {
        $orders = DB::table('orders')->where('orders.customer_id','=',$this->id);
        if ($status != -5) {
            $orders->where('orders.status','=',$status);
        }
        $orders->join('order_logs',function ($join){
                    $join->on('order_logs.order_id','=','orders.id')
                    ->where('order_logs.status',Order::ACCEPTED);
                    })
                    ->join('trucks',function ($query)
                    {
                        $query->on('orders.truck_id','=','trucks.id');
                    })
                    ->select('orders.*','order_logs.location as location_from','orders.location as location_to','trucks.location as location_current','order_logs.lat as lat_from','order_logs.lng as lng_from','orders.lat as lat_to','orders.lng as lng_to','trucks.lat as lat_current','trucks.lng as lng_current','trucks.driver_name as current_driver','trucks.plate_num','trucks.desc','trucks.lat as truck_lat','trucks.lng as truck_lng','trucks.status as truck_status','trucks.image','orders.status as order_status');

        return $orders;
    }

    public function pending_orders(){
        // $orders = Order::join('')
        $orders = $this->orders()->where('status',Order::PENDING);
        return $orders;
    }

    public function accepted_orders(){
        $orders = $this->orders()->where('status',Order::ACCEPTED);
        return $orders;
    }

    public function completed_orders(){
        $orders = $this->orders()->where('status',Order::DONE);
        return $orders;
    }

    public function rejected_orders(){
        $orders = $this->orders()->where('status',Order::REJECTED);
        return $orders;
    }

    public function canceled_orders(){
        $orders = $this->orders()->where('status',Order::CANCELED);
        return $orders;
    }

    public function shifts()
    {
        $driver_id = $this->id;
        $shifts = DB::table('customer_truck')
                ->join('trucks', function ($join) use ($driver_id) {
                    $join->on('customer_truck.truck_id', '=', 'trucks.id')
                         ->where('customer_truck.customer_id', '=', $driver_id);
                })
                ->select('customer_truck.*','trucks.*');  

        return $shifts;
    }

}

