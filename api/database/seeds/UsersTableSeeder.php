<?php

use Illuminate\Database\Seeder;

use App\User;
use App\Role;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'email' => 'user@gmail.com',
                'first_name' => 'Tom',
                'last_name' => 'Tomic',
                'role_id' => 2,
                'gender_id' => 1
            ],
            [
                'email' => 'tom@gmail.com',
                'first_name' => 'Tom',
                'last_name' => 'Tomic',
                'role_id' => 2,
                'gender_id' => 1
            ]
        ];

        foreach($users as $user) {
            factory(User::class)->create($user);
        }
    }
}
