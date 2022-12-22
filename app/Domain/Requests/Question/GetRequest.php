<?php

namespace App\Domain\Requests\Question;

use App\Domain\Contracts\Contract;
use App\Domain\Requests\MainRequest;

class GetRequest extends MainRequest
{
    public function rules():array
    {
        return [
            Contract::IS_PAID   =>  'nullable|boolean',
            Contract::STATUS    =>  'nullable'
        ];
    }

    public function checked(): array
    {
        $data   =   $this->validator->validated();
        $arr    =   [];
        foreach ($data as $key => $value) {
            $arr[]  =   [$key,$value];
        }
        return $arr;
    }
}
