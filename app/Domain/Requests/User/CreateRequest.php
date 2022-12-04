<?php

namespace App\Domain\Requests\User;

use App\Domain\Contracts\Contract;
use App\Domain\Requests\MainRequest;

class CreateRequest extends MainRequest
{
    public function rules():array
    {
        return [
            Contract::ROLE  =>  'required|in:'.join(',',[Contract::USER,Contract::ADMIN,Contract::LAWYER]),
            Contract::LANGUAGE_ID   =>  'required|exists:languages,id',
            Contract::REGION_ID =>  'required|exists:regions,id',
            Contract::NAME      =>  'required',
            Contract::SURNAME   =>  'required',
            Contract::LAST_NAME =>  'nullable',
            Contract::GENDER    =>  'nullable|in:'.join(',',[Contract::MALE,Contract::FEMALE]),
            Contract::PHONE     =>  'required|unique:users,phone',
            Contract::PASSWORD  =>  'required|min:8',
            Contract::PUSH_NOTIFICATION =>  'nullable|boolean',
        ];
    }

    public function checked(): array
    {
        $data   =   $this->validator->validated();
        $data[Contract::PHONE_CODE] =   rand(1000,9999);
        return $data;
    }
}
