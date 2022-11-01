<?php

namespace App\Domain\Services;

use App\Domain\Repositories\Language\LanguageRepositoryInterface;

class LanguageService extends Service
{
    public LanguageRepositoryInterface $languageRepository;
    public function __construct(LanguageRepositoryInterface $languageRepository)
    {
        $this->languageRepository   =   $languageRepository;
    }
}
