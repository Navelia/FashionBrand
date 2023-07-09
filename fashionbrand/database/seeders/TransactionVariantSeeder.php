<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TransactionVariantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('transactions_variants')->insert([
            'transaction_id'=>1,
            'variant_id'=>1,
            'price'=>599000,
            'quantity'=>1,
            'sub_total'=>599000,
        ]);
        DB::table('transactions_variants')->insert([
            'transaction_id'=>1,
            'variant_id'=>4,
            'price'=>299000,
            'quantity'=>1,
            'sub_total'=>299000,
        ]);
    }
}
