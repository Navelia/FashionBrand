<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('types')->insert([
            'name'=>'Sweater',
            'description'=>'Baju dari bahan yang tebal, dipakai pada waktu udara (cuaca) dingin',
            'unit'=>'pcs',
            'created_at'=>date('Y-m-d H:i:s'),
            'updated_at'=>date('Y-m-d H:i:s'),
        ]);
        DB::table('types')->insert([
            'name'=>'Jaket',
            'description'=>'Baju luar berlengan dengan bukaan di depan (untuk penahan dingin atau angin)',
            'unit'=>'pcs',
            'created_at'=>date('Y-m-d H:i:s'),
            'updated_at'=>date('Y-m-d H:i:s'),
        ]);
        DB::table('types')->insert([
            'name'=>'Kemeja',
            'description'=>'baju laki-laki, pada umumnya berkerah dan berkancing depan, terbuat dari katun, linen, dan sebagainya (ada yang berlengan panjang, ada yang berlengan pendek)',
            'unit'=>'pcs',
            'created_at'=>date('Y-m-d H:i:s'),
            'updated_at'=>date('Y-m-d H:i:s'),
        ]);
    }
}
