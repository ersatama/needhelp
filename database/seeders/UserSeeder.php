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
             Contract::PHONE_VERIFIED_AT    =>  now(),
             Contract::EMAIL    =>  'admin@needhelp.com',
             Contract::EMAIL_VERIFIED_AT    =>  now(),
             Contract::PASSWORD =>  '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',//password
             Contract::REMEMBER_TOKEN   =>  Str::random(10),
         ]);
    }
}
