<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoryProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories_products')->insert([
            'category_id'=>1,
            'product_id'=>1,
        ]);
        DB::table('categories_products')->insert([
            'category_id'=>2,
            'product_id'=>1,
        ]);
        DB::table('categories_products')->insert([
            'category_id'=>1,
            'product_id'=>2,
        ]);
        DB::table('categories_products')->insert([
            'category_id'=>2,
            'product_id'=>2,
        ]);
        DB::table('categories_products')->insert([
            'category_id'=>3,
            'product_id'=>2,
        ]);
        DB::table('categories_products')->insert([
            'category_id'=>1,
            'product_id'=>3,
        ]);
    }
}
