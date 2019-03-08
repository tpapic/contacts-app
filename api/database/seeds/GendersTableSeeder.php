<?php

use Illuminate\Database\Seeder;
use App\Gender;

class GendersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /* genders */
        $json = File::get("database/seeds/data/genders.json");
        $genders = json_decode($json);
        foreach ($genders as $gender) {
            Gender::create([
                'name' => $gender->name
            ]);
        }
    }
}
