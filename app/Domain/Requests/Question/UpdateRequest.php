<?php

namespace App\Domain\Requests\Question;

use App\Domain\Contracts\Contract;
use App\Domain\Requests\MainRequest;

class UpdateRequest extends MainRequest
{
    public function rules():array
    {
        return [
            Contract::LAWYER_ID =>  'required|exists:users,id',
            Contract::ANSWER    =>  'required',
        ];
    }

    public function checked(): array
    {
        $data   =   $this->validator->validated();
        $data[Contract::ANSWERED_AT]    =   now();
        $data[Contract::IS_NEW] =   true;
        $data[Contract::STATUS] =   2;
        return $data;
    }
}
