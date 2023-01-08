<?php

namespace App\Domain\Requests\User;

use App\Domain\Contracts\Contract;
use App\Domain\Requests\MainRequest;
use Illuminate\Support\Facades\Hash;

class UpdateRequest extends MainRequest
{
    public function rules():array
    {
        return [
            Contract::LANGUAGE_ID   =>  'nullable|exists:languages,id',
            Contract::PUSH_NOTIFICATION =>  'nullable|boolean',
            Contract::PASSWORD  =>  'nullable'
        ];
    }

    public function checked(): array
    {
        $data   =   $this->validator->validated();
        if (array_key_exists(Contract::PASSWORD, $data)) {
            $data[Contract::PASSWORD]   =   Hash::make($data[Contract::PASSWORD]);
        }
        return $data;
    }
}
