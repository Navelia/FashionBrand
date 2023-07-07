<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->insert([
            'name'=>'Jaket Parka Saku Proteksi Sinar UV Potongan 3D (Water-Repellent)',
            'brand'=>'Unik-lo',
            'price'=>599000,
            'dimension'=>'s,m,l,xl',
            'image_url'=>'products/uniklo-parka-abu.png',
            'type_id'=>2,
            'created_at'=>date('Y-m-d H:i:s'),
            'updated_at'=>date('Y-m-d H:i:s'),
        ]);
        DB::table('products')->insert([
            'name'=>'Sweater Sulaman Slogan Basic',
            'brand'=>'Push&Bear',
            'price'=>299000,
            'dimension'=>'s,m,l,xl',
            'image_url'=>'products/push-n-bear-sulaman-slogan.jpg',
            'type_id'=>1,
            'created_at'=>date('Y-m-d H:i:s'),
            'updated_at'=>date('Y-m-d H:i:s'),
        ]);
        DB::table('products')->insert([
            'name'=>'Easy Care Textured Shirt',
            'brand'=>'Zara',
            'price'=>225000,
            'dimension'=>'m,l,xl,xxl',
            'image_url'=>'products/uniqlo-parka-abu.png',
            'type_id'=>2,
            'created_at'=>date('Y-m-d H:i:s'),
            'updated_at'=>date('Y-m-d H:i:s'),
        ]);
    }
}
