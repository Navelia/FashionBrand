<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PointHistorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('points_history')->insert([
            'date'=>date('Y-m-d H:i:s'),
            'type'=>'IN',
            'amount'=>8,
            'transaction_id'=>1,
        ]);
    }
}
