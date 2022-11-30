<?php

namespace App\Domain\Requests\User;

use App\Domain\Contracts\Contract;
use App\Domain\Requests\MainRequest;

class SearchRequest extends MainRequest
{
    public function rules():array
    {
        return [
            Contract::Q     =>  'nullable',
            Contract::PAGE  =>  'nullable'
        ];
    }

    public function checked()
    {
        $data   =   $this->validator->validated();
        if (array_key_exists(Contract::Q, $data)) {
            return $data[Contract::Q];
        }
        return false;
    }
}
