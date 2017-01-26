<?php

use App\Sale;
use Illuminate\Database\Seeder;

class SaleTableSeeder extends Seeder
{
    /**
     * Seed the tags table
     */
    public function run()
    {
        Sale::truncate();

        factory(Sale::class, 5)->create();
    }
}