<?php

namespace App\Http\Controllers\Api;

use App\Domain\Services\IpService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IpController extends Controller
{
    protected IpService $ipService;
    public function __construct(IpService $ipService)
    {
        $this->ipService    =   $ipService;
    }
}
