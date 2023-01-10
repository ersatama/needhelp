<?php

use App\Domain\Contracts\Contract;

return [
    Contract::AUTH              =>  'https://api-core.wooppay.com/v1/auth',
    Contract::CREATE            =>  'https://api-core.wooppay.com/v1/invoice/create',
    Contract::STATUS            =>  'https://api-core.wooppay.com/v1/history/transaction/get-operations-data',
    Contract::REQUEST_URL       =>  env('APP_URL').'/api/v1/wooppay/request',
    Contract::BACK_URL          =>  env('APP_URL').'/api/v1/wooppay/back',
    Contract::DESCRIPTION       =>  'Оплата NeedHelp вопроса',
    Contract::OPTION            =>  4,
    Contract::CARD_FORBIDDEN    =>  0,
    Contract::PREFIX            =>  'need_help'
];
