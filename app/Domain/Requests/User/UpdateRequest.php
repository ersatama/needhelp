<?php

namespace App\Domain\Requests\User;

use App\Domain\Contracts\Contract;
use App\Domain\Requests\MainRequest;

class UpdateRequest extends MainRequest
{
    public function rules():array
    {
        return [
            Contract::LANGUAGE_ID   =>  'required|exists:languages,id',
            Contract::PUSH_NOTIFICATION =>  'nullable|boolean',
        ];
    }

    public function checked(): array
    {
        return $this->validator->validated();
    }
}
