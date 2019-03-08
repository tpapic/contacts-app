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
            'user_id' => 1
          ],
          [
            'first_name' => 'Iva',
            'last_name' => 'Ivic',
            'profile_photo' => 'no_image.png',
            'email' => 'iva@gmail.com',
            'favorite' => true,
            'user_id' => 2
          ],
          [
            'first_name' => 'Luka',
            'last_name' => 'Lukic',
            'profile_photo' => 'no_image.png',
            'email' => 'luka@gmail.com',
            'favorite' => false,
            'user_id' => 2
          ]
        ];

      $numbers = [
        [
          ['label' => 'Phone', 'number' => '222222'],
          ['label' => 'Mob', 'number' => '333333']
        ],
        [
          ['label' => 'Phone', 'number' => '123456'],
          ['label' => 'Mob', 'number' => '123456789']
        ],
        [
          ['label' => 'Phone', 'number' => '1111111'],
          ['label' => 'Mob', 'number' => '4444444']
        ],
        [
          ['label' => 'Phone', 'number' => '55555555'],
          ['label' => 'Mob', 'number' => '66666666']
        ]
      ];

      for ($i = 0; $i < count($contacts); $i++) {
        $contactCreated = Contact::create($contacts[$i]);
        $contactCreated->numbers()->createMany($numbers[$i]);
      }
    }
}
