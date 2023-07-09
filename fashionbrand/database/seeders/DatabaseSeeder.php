<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // User::factory(10)->create();
        $this->call(CategorySeeder::class);
        $this->call(TypeSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(CustomerSeeder::class);
        $this->call(ProductSeeder::class);
        $this->call(CategoryProductSeeder::class);
        $this->call(VariantSeeder::class);
        $this->call(TransactionSeeder::class);
        $this->call(TransactionVariantSeeder::class);
        $this->call(PointHistorySeeder::class);
    }
}
