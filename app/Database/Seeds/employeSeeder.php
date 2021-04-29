<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class employeSeeder extends Seeder
{
    public function run()
    {
        $faker = \Faker\Factory::create('id_ID');


        for ($i = 0; $i < 50000; $i++) {
            $nik = $faker->nik();
            $fullname = $faker->name();
            $address = $faker->address();
            $agama = 'Islam';
            $data = [
                'nik'    => $nik,
                'fullname'    => $fullname,
                'address'    => $address,
                'agama'    => $agama,
            ];
            $this->db->table('tbl_employe')->insert($data);
        }
    }
}
