<?php

namespace App\Domain\Requests\User;

use App\Domain\Contracts\Contract;
use App\Domain\Requests\MainRequest;

class CreateRequest extends MainRequest
{
    public function rules():array
    {
        return [
            Contract::LANGUAGE_ID   =>  'required|exists:languages,id',
            Contract::REGION_ID =>  'required|exists:regions,id',
            Contract::NAME      =>  'required',
            Contract::SURNAME   =>  'required',
            Contract::LAST_NAME =>  'nullable',
            Contract::PHONE     =>  'required|unique:users,phone',
            Contract::PUSH_NOTIFICATION =>  'nullable|boolean',
        ];
    }

    public function checked(): array
    {
        $data   =   $this->validator->validated();
        $data[Contract::ROLE]   =   Contract::USER;
        return $data;
    }
}
