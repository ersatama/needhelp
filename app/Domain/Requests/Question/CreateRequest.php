<?php

namespace App\Domain\Requests\Question;

use App\Domain\Contracts\Contract;
use App\Domain\Requests\MainRequest;

class CreateRequest extends MainRequest
{
    public function rules():array
    {
        return [
            Contract::USER_ID   =>  'required|exists:users,id',
            Contract::PAYMENT_ID    =>  'required|exists:payments,id',
            Contract::PRICE     =>  'required',
            Contract::TITLE     =>  'required',
            Contract::IS_IMPORTANT  =>  'required|boolean',
        ];
    }

    public function checked(): array
    {
        $data   =   $this->validator->validated();
        $data[Contract::CURRENCY_ID]    =   1;
        $data[Contract::IS_PAID]    =   true;
        $data[Contract::STATUS]     =   1;
        $data[Contract::IS_NEW]     =   false;
        return $data;
    }
}
