<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Role;
use App\Permission;
use App\Models\Supplier;
use App\Models\Truck;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);

    	DB::table('users')->delete();
        //1) Create Admin Role
    	$role = ['name' => 'admin', 'display_name' => 'Admin', 'description' => 'Full Permission'];
    	$role = Role::create($role);
        //2) Set Role Permissions
        // Get all permission, swift through and attach them to the role
    	$permission = Permission::get();
    	foreach ($permission as $key => $value) {
    		$role->attachPermission($value);
    	}
        //3) Create Admin User
    	$user = ['name' => 'Admin User', 'email' => 'admin@mssoft.com', 'password' => Hash::make('secret'),'is_verified'=>1,'code'=>0];
    	$user = User::create($user);
        //4) Set User Role
    	$user->attachRole($role);


    	$role2 = ['name' => 'customer', 'display_name' => 'Customer', 'description' => 'API Permissions'];
    	$role2 = Role::create($role2);


    	$role3 = ['name' => 'supplier', 'display_name' => 'Supplier', 'description' => 'Truck Office Permissions'];
    	$role3 = Role::create($role3);

        $role4 = ['name' => 'driver', 'display_name' => 'Driver', 'description' => 'Truck driver'];
        $role4 = Role::create($role4);

        //5) Create Supplier User
        $s_user = ['name' => 'Supplier User', 'email' => 'supplier@mssoft.com', 'password' => Hash::make('secret'),'is_verified'=>1,'code'=>0];
        $s_user = User::create($s_user);
        //6) Set Supplier Role
        $s_user->attachRole($role3);
        //7) Create Supplier
        $supplier = ['name' => 'Supplier','location'=> 'Damascus','lat'=> 0,'lng' => 0,'description' => 'Supplier description','phone' => '09934904212','is_verified' =>1,'expire_date'=>'1/1/2019','user_id'=>$s_user->id];
        $supplier = Supplier::create($supplier);
        $supplier->user()->associate($s_user);

        //8) Create Truck
        $truck = ['driver_name' => 'Driver','location'=> 'Damascus','lat'=> 0,'lng' => 0,'capacity'=>25,'model'=>'Mercedes benz 2018','plate_num' => '4455ffgs','driver_phone' => '0934904212','company_phone' => '0934904212','expire_date'=>'1/1/2019','supplier_id'=>$supplier->id,'price_km'=>400,'price_h'=>450,'rating'=>0,'image'=>'images/nkhLNt6eUwtLnfRAz1wQdUSwbvCSWWIYr0L9fsWk.jpeg','distances'=>0,'licence_date'=>'2019-1-19','status' =>Truck::ONLINE];

        $truck2 = ['driver_name' => 'Driver 2','location'=> 'Damascus','lat'=> 0,'lng' => 0,'capacity'=>25,'model'=>'Mercedes benz 2018','plate_num' => '4455ffgs','driver_phone' => '0934904212','company_phone' => '0934904212','expire_date'=>'1/1/2019','supplier_id'=>$supplier->id,'price_km'=>400,'price_h'=>450,'rating'=>0,'image'=>'images/nkhLNt6eUwtLnfRAz1wQdUSwbvCSWWIYr0L9fsWk.jpeg','distances'=>0,'licence_date'=>'2019-1-19','status' =>Truck::ONLINE];

        $truck = Truck::create($truck);
        $truck->supplier()->associate($supplier);

        $truck2 = Truck::create($truck2);
        $truck2->supplier()->associate($supplier);



    }
}
