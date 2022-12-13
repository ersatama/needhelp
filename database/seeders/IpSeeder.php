<?php

namespace Database\Seeders;

use App\Domain\Contracts\Contract;
use App\Models\Ip;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IpSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $ips    =   [
            ['127.0.0.1','localhost',true],
            ['37.99.39.166','developer',true],
            ['37.99.36.132','developer #2', true],
            ['78.40.109.43','needhelp.kz',true],
            ['151.210.128.51','Kamiyar',true]
        ];
        foreach ($ips as &$ip) {
            Ip::create([
                Contract::IP    =>  $ip[0],
                Contract::TITLE =>  $ip[1],
                Contract::STATUS    =>  true
            ]);
        }
    }
}
