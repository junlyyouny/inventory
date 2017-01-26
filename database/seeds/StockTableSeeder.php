<?php

use App\Stock;
use Illuminate\Database\Seeder;

class StockTableSeeder extends Seeder
{
    /**
     * Seed the tags table
     */
    public function run()
    {
        Stock::truncate();

        factory(Stock::class, 10)->create();
    }
}