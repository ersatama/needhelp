<?php

namespace Database\Seeders;

use App\Domain\Contracts\Contract;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
            // \App\Models\User::factory(10)->create();
         User::factory()->create([
             Contract::ROLE =>  Contract::ADMIN,
             Contract::NAME =>  Contract::ADMIN,
             Contract::SURNAME  =>  Contract::ADMIN,
             Contract::PHONE    =>  null,
             Contract::EMAIL    =>  'admin@needhelp.com',
             Contract::PASSWORD =>  'password',//password
             Contract::REMEMBER_TOKEN   =>  Str::random(10),
         ]);
        User::factory()->create([
            Contract::ROLE =>  Contract::LAWYER,
            Contract::NAME =>  Contract::LAWYER,
            Contract::SURNAME  =>  Contract::LAWYER,
            Contract::PHONE    =>  null,
            Contract::EMAIL    =>  'lawyer@needhelp.com',
            Contract::PASSWORD =>  'password',//password
            Contract::REMEMBER_TOKEN   =>  Str::random(10),
        ]);
        User::factory()->create([
            Contract::ROLE =>  Contract::USER,
            Contract::NAME =>  Contract::USER,
            Contract::SURNAME  =>  Contract::USER,
            Contract::PHONE    =>  null,
            Contract::EMAIL    =>  'user@needhelp.com',
            Contract::PASSWORD =>  'password',//password
            Contract::REMEMBER_TOKEN   =>  Str::random(10),
        ]);
    }
}
