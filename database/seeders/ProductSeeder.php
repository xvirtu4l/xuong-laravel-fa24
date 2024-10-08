<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('products')->insert([
            ['id' => 1, 'name' => 'Bàn gỗ', 'price' => 2000000, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'name' => 'Ghế xoay', 'price' => 1500000, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'name' => 'Dụng cụ ăn', 'price' => 500000, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 4, 'name' => 'Giường ngủ', 'price' => 800000, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
