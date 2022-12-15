<?php

namespace Database\Seeders;

use App\Domain\Contracts\Contract;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TestUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        User::factory()->create([
            Contract::ROLE =>  Contract::USER,
            Contract::NAME =>  Contract::USER,
            Contract::SURNAME  =>  Contract::USER,
            Contract::PHONE    =>  77776665544,
            Contract::EMAIL    =>  'test@needhelp.com',
            Contract::PASSWORD =>  '1234',//password
            Contract::REMEMBER_TOKEN   =>  Str::random(10),
        ]);
    }
}
