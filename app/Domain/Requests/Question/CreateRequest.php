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
            Contract::PAYMENT_ID    =>  'required|integer|exists:payments,id',
            Contract::PRICE     =>  'required',
            Contract::TITLE     =>  'required|string|max:10000',
            Contract::IS_IMPORTANT  =>  'required|boolean',
        ];
    }

    public function checked(): array
    {
        $data   =   $this->validator->validated();
        $data[Contract::PAYMENT_ID] =   intval($data[Contract::PAYMENT_ID]);
        $data[Contract::CURRENCY_ID]    =   1;
        $data[Contract::IS_PAID]    =   false;
        $data[Contract::STATUS]     =   0;
        $data[Contract::IS_NEW]     =   false;
        return $data;
    }
}
