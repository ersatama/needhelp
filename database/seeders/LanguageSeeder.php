<?php

namespace Database\Seeders;

use App\Domain\Contracts\Contract;
use App\Models\Language;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        Language::create([
            Contract::TITLE =>  'Русский',
            Contract::TITLE_KZ  =>  'Орысша',
            Contract::TITLE_EN  =>  'Russian',
        ]);
        Language::create([
            Contract::TITLE =>  'Английский',
            Contract::TITLE_KZ  =>  'Ағылшынша',
            Contract::TITLE_EN  =>  'English',
        ]);
        Language::create([
            Contract::TITLE =>  'Казахский',
            Contract::TITLE_KZ  =>  'Қазақша',
            Contract::TITLE_EN  =>  'Kazakh',
        ]);
    }
}
