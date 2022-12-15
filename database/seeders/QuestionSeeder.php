<?php

namespace Database\Seeders;

use App\Domain\Contracts\Contract;
use App\Models\Question;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        for ($i=0;$i<5;$i++) {
            Question::create([
                Contract::USER_ID   =>  3,
                Contract::CURRENCY_ID   =>  1,
                Contract::PRICE =>  3000,
                Contract::TITLE =>  'Lorem ipsum dolor sit amet, consectetur adipiscing elit '.$i,
                Contract::DESCRIPTION   =>  'Lorem ipsum dolor sit amet, consectetur adipiscing elit '.$i,
                Contract::IS_IMPORTANT  =>  false,
                Contract::IS_PAID   =>  false,
                Contract::STATUS    =>  1,
            ]);
            Question::create([
                Contract::USER_ID   =>  3,
                Contract::CURRENCY_ID   =>  1,
                Contract::PRICE =>  3000,
                Contract::TITLE =>  'Lorem ipsum dolor sit amet, consectetur adipiscing elit '.$i,
                Contract::DESCRIPTION   =>  'Lorem ipsum dolor sit amet, consectetur adipiscing elit '.$i,
                Contract::IS_IMPORTANT  =>  false,
                Contract::IS_PAID   =>  true,
                Contract::STATUS    =>  0,
            ]);
            Question::create([
                Contract::USER_ID   =>  3,
                Contract::CURRENCY_ID   =>  1,
                Contract::PRICE =>  3000,
                Contract::PAYMENT_ID    =>  rand(100000,999999),
                Contract::TITLE =>  'Lorem ipsum dolor sit amet, consectetur adipiscing elit '.$i,
                Contract::DESCRIPTION   =>  'Lorem ipsum dolor sit amet, consectetur adipiscing elit '.$i,
                Contract::IS_IMPORTANT  =>  false,
                Contract::IS_PAID   =>  true,
                Contract::STATUS    =>  1,
            ]);
            Question::create([
                Contract::USER_ID   =>  3,
                Contract::CURRENCY_ID   =>  1,
                Contract::LAWYER_ID =>  2,
                Contract::PRICE =>  3000,
                Contract::PAYMENT_ID    =>  rand(100000,999999),
                Contract::TITLE =>  'Lorem ipsum dolor sit amet, consectetur adipiscing elit '.$i,
                Contract::DESCRIPTION   =>  'Lorem ipsum dolor sit amet, consectetur adipiscing elit '.$i,
                Contract::ANSWER    =>  'Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
                Contract::IS_IMPORTANT  =>  false,
                Contract::IS_PAID   =>  true,
                Contract::STATUS    =>  2,
                Contract::ANSWERED_AT   =>  now(),
            ]);
        }
    }
}
