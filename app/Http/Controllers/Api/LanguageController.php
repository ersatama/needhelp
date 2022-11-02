<?php

namespace App\Http\Controllers\Api;

use App\Domain\Services\LanguageService;
use App\Http\Controllers\Controller;
use App\Http\Resources\Language\LanguageCollection;
use Illuminate\Http\Request;

class LanguageController extends Controller
{
    protected LanguageService $languageService;
    public function __construct(LanguageService $languageService)
    {
        $this->languageService  =   $languageService;
    }

    /**
     * get - Language
     *
     * @group Language
     */
    public function get(): LanguageCollection
    {
        return new LanguageCollection($this->languageService->languageRepository->get());
    }
}
