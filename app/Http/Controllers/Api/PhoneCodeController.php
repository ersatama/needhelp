<?php

namespace App\Http\Controllers\Api;

use App\Domain\Services\PhoneCodeService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PhoneCodeController extends Controller
{
    protected PhoneCodeService $phoneCodeService;
    public function __construct(PhoneCodeService $phoneCodeService)
    {
        $this->phoneCodeService =   $phoneCodeService;
    }
}
