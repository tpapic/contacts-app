<?php

use Illuminate\Database\Seeder;
use App\Util\General\Permission;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            'Admin',
            'User'
        ];
        Permission::addRoles($roles);
    }
}
