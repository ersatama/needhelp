<?php

namespace Database\Seeders;

use App\Domain\Contracts\Contract;
use App\Models\Payment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        Payment::create([
            Contract::TITLE =>  'Wooppay',
            Contract::LOGIN =>  'test_merch',
            Contract::PASSWORD  =>  'A12345678a'
        ]);
        Payment::create([
            Contract::TITLE =>  'Kaspi',
            Contract::LOGIN =>  '',
            Contract::PASSWORD  =>  ''
        ]);
    }
}
