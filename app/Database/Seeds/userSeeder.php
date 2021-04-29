<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class userSeeder extends Seeder
{
    public function run()
    {
        $faker = \Faker\Factory::create('id_ID');


        for ($i = 0; $i < 10000; $i++) {
            $fullname = $faker->name();
            $email = $faker->email();
            $phone = $faker->phoneNumber();
            $data = [
                'fullname'    => $fullname,
                'email'    => $email,
                'phone'    => $phone,
                'created_at' => Time::createFromTimestamp($faker->unixTime()),
                'updated_at' => Time::createFromTimestamp($faker->unixTime())
            ];
            $this->db->table('tbl_user')->insert($data);
        }
    }
}
