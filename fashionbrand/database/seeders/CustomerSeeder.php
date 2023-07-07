<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('customers')->insert([
            'points'=>8,
            'address'=>'Jl.Manyar Adi 12222',
            'phone_number'=>'081234567890',
            'user_id'=>3,
        ]);
    }
}
