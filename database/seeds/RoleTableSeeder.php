<?php

use Illuminate\Database\Seeder;
use App\Role;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roleGuest = new Role();
        $roleGuest->name = ('Guest');
        $roleGuest->description = ('Only for registering new guests!');
        $roleGuest->save();

        $roleAdmin = new Role();
        $roleAdmin->name = ('Admin');
        $roleAdmin->description = ('Admin Users can do anything in the app, no restrictions!');
        $roleAdmin->save();
    }
}
