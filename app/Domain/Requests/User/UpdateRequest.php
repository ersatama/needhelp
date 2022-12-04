<?php

namespace App\Domain\Requests\User;

use App\Domain\Contracts\Contract;
use App\Domain\Requests\MainRequest;

class UpdateRequest extends MainRequest
{
    public function rules():array
    {
        return [
            Contract::ROLE  =>  'required|in:'.join(',',[Contract::USER,Contract::ADMIN,Contract::LAWYER]),
            Contract::LANGUAGE_ID   =>  'required|exists:languages,id',
            Contract::CITY_ID   =>  'required|exists:cities,id',
            Contract::NAME  =>  'required',
            Contract::SURNAME   =>  'required',
            Contract::LAST_NAME =>  'nullable',
            Contract::GENDER    =>  'nullable|in:'.join(',',[Contract::MALE,Contract::FEMALE]),
            Contract::EMAIL     =>  'nullable',
            Contract::PASSWORD  =>  'required|min:8',
            Contract::PUSH_NOTIFICATION =>  'nullable|boolean',
        ];
    }

    public function checked(): array
    {
        return $this->validator->validated();
    }
}
