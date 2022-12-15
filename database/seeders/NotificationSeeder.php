<?php

namespace Database\Seeders;

use App\Domain\Contracts\Contract;
use App\Models\Notification;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        Notification::create([
            Contract::USER_ID   =>  3,
            Contract::TYPE  =>  1,
            Contract::QUESTION_ID   =>  4,
            Contract::STATUS    =>  true
        ]);
        Notification::create([
            Contract::USER_ID   =>  3,
            Contract::TYPE  =>  1,
            Contract::QUESTION_ID   =>  8,
            Contract::STATUS    =>  true
        ]);
        Notification::create([
            Contract::USER_ID   =>  3,
            Contract::TYPE  =>  1,
            Contract::QUESTION_ID   =>  12,
            Contract::STATUS    =>  true
        ]);
        Notification::create([
            Contract::USER_ID   =>  3,
            Contract::TYPE  =>  1,
            Contract::QUESTION_ID   =>  16,
            Contract::STATUS    =>  true
        ]);
        Notification::create([
            Contract::USER_ID   =>  3,
            Contract::TYPE  =>  1,
            Contract::QUESTION_ID   =>  20,
            Contract::STATUS    =>  true
        ]);
    }
}
