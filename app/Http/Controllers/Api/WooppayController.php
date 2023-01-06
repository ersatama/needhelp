<?php

namespace App\Http\Controllers\Api;

use App\Domain\Services\WooppayService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WooppayController extends Controller
{
    protected WooppayService $wooppayService;
    public function __construct(WooppayService $wooppayService)
    {
        $this->wooppayService   =   $wooppayService;
    }

    public function request(Request $request)
    {
        Log::info('request', [$request->all()]);
    }

    public function back(Request $request)
    {
        Log::info('back', [$request->all()]);
    }
}
