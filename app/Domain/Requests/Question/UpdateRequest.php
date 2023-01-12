<?php

namespace App\Domain\Requests\Question;

use App\Domain\Contracts\Contract;
use App\Domain\Requests\MainRequest;

class UpdateRequest extends MainRequest
{
    public function rules():array
    {
        return [
            Contract::LAWYER_ID =>  'nullable|exists:users,id',
            Contract::ANSWER    =>  'nullable',
        ];
    }

    public function checked(): array
    {
        $data   =   $this->validator->validated();
        if (array_key_exists(Contract::ANSWER, $data)) {
            $data[Contract::ANSWERED_AT]    =   now();
            $data[Contract::IS_NEW] =   true;
            $data[Contract::STATUS] =   2;
        }
        return $data;
    }
}
