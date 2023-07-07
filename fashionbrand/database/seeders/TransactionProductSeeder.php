<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TransactionProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('transactions_products')->insert([
            'transaction_id'=>1,
            'product_id'=>1,
            'price'=>599000,
            'dimension'=>'l',
            'quantity'=>1,
            'sub_total'=>599000,
        ]);
        DB::table('transactions_products')->insert([
            'transaction_id'=>1,
            'product_id'=>2,
            'price'=>299000,
            'dimension'=>'xl',
            'quantity'=>1,
            'sub_total'=>299000,
        ]);
    }
}
