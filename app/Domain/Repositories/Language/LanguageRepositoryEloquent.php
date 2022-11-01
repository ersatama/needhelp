<?php

namespace App\Domain\Repositories\Language;

use App\Domain\Repositories\RepositoryEloquent;
use App\Models\Language;

class LanguageRepositoryEloquent implements LanguageRepositoryInterface
{
    use RepositoryEloquent;
    protected Language $model;
    public function __construct(Language $language)
    {
        $this->model    =   $language;
    }
}
