<?php

use Illuminate\Database\Seeder;
use App\Contact;

class ContactsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $contacts = [
          [
            'first_name' => 'Tom',
            'last_name' => 'Foo',
            'profile_photo' => 'no_image.png',
            'email' => 'tom@gmail.com',
            'favorite' => true,
            'user_id' => 1
          ],
          [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'profile_photo' => 'no_image.png',
            'email' => 'john@gmail.com',
            'favorite' => false,
            'user_id' => 2
          ]
        ];

    foreach ($contacts as $contact) {
      Contact::create($contact);
    }
    }
}
