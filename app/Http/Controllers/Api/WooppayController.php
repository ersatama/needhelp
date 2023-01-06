<?php

namespace App\Http\Controllers\Api;

use App\Domain\Contracts\Contract;
use App\Domain\Helpers\Wooppay;
use App\Domain\Services\WooppayService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WooppayController extends Controller
{
    protected WooppayService $wooppayService;
    protected Wooppay $wooppay;

    public function __construct(WooppayService $wooppayService, Wooppay $wooppay)
    {
        $this->wooppayService   =   $wooppayService;
        $this->wooppay          =   $wooppay;
    }

    public function request(Request $request)
    {
        if ($request->has(Contract::ID)) {
            $questionId =   (int) $request->input(Contract::ID);
            if ($wooppay = $this->wooppayService->wooppayRepository->firstByQuestionId($questionId)) {
                $status =   $this->wooppay->status($wooppay);
                Log::info('request-status', [$status]);
            }
        }
    }

    public function back(Request $request)
    {
        Log::info('back', [$request->all()]);
    }
}
