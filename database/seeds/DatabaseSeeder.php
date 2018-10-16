<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Role;
use App\Permission;
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

    }
}
