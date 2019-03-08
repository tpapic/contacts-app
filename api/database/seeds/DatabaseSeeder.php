<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(SocialProvidersSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(ActionsTableSeeder::class);
        $this->call(GendersTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(ContactsTableSeeder::class);
    }
}

