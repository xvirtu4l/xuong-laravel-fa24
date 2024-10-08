<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FinancialReportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('financial_reports')->insert([
            [
                'id' => 1, 
                'month' => 9, 
                'year' => 2024, 
                'total_sales' => 32000000, 
                'total_expenses' => 18800000, 
                'profit_before_tax' => 13200000, 
                'tax_amount' => 3200000, 
                'profit_after_tax' => 10000000, 
                'created_at' => now(), 
                'updated_at' => now()
            ],
        ]);
    }
}
