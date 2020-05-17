<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Role;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roleAdmin = Role::where('name', 'Admin')->first()->id;
        $userAdmin = new User();
        $userAdmin->name = ('admin');
        $userAdmin->email = ('admin_test@example.com');
        $userAdmin->password = bcrypt('admin');
        $userAdmin->role_id = $roleAdmin;
        $userAdmin->save();

        $roleGuest = Role::where('name', 'Guest')->first()->id;
        $userGuest = new User();
        $userGuest->name = ('guest_test');
        $userGuest->email = ('guest_test@example.com');
        $userGuest->password = bcrypt('testtest');
        $userGuest->role_id = $roleGuest;
        $userGuest->save();
    }
}
