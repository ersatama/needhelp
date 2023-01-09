<?php

namespace App\Domain\Repositories\Wooppay;

use App\Domain\Contracts\Contract;
use App\Domain\Repositories\RepositoryEloquent;
use App\Domain\Scopes\IsPaid;
use App\Models\Wooppay;

class WooppayRepositoryEloquent implements WooppayRepositoryInterface
{
    use RepositoryEloquent;
    protected Wooppay $model;
    public function __construct(Wooppay $wooppay)
    {
        $this->model    =   $wooppay;
    }

    public function firstByQuestionId($questionId)
    {
        return $this->model::where(Contract::QUESTION_ID, $questionId)->withoutGlobalScope(IsPaid::class)->first();
    }
}
