<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SaleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('sales')->insert([
            ['id' => 1, 'product_id' => 1, 'quantity' => 3, 'price' => 2000000, 'total' => 6000000, 'sale_date' => '2024-09-05', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'product_id' => 2, 'quantity' => 5, 'price' => 1500000, 'total' => 7500000, 'sale_date' => '2024-09-16', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'product_id' => 3, 'quantity' => 10, 'price' => 500000, 'total' => 5000000, 'sale_date' => '2024-09-20', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 4, 'product_id' => 4, 'quantity' => 2, 'price' => 800000, 'total' => 1600000, 'sale_date' => '2024-09-30', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
