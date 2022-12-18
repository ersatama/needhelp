<?php

namespace Database\Seeders;

use App\Domain\Contracts\Contract;
use App\Models\Price;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PriceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        Price::create([
            Contract::CURRENCY_ID   =>  1,
            Contract::PRICE =>  3000,
            Contract::IMPORTANT_PRICE   =>  4500
        ]);
    }
}
