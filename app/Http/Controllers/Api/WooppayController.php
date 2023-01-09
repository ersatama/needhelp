<?php

namespace App\Http\Controllers\Api;

use App\Domain\Contracts\Contract;
use App\Domain\Helpers\Wooppay;
use App\Domain\Services\QuestionService;
use App\Domain\Services\WooppayService;
use App\Http\Controllers\Controller;
use App\Jobs\QuestionJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WooppayController extends Controller
{
    protected WooppayService $wooppayService;
    protected QuestionService $questionService;
    protected Wooppay $wooppay;

    public function __construct(WooppayService $wooppayService, Wooppay $wooppay, QuestionService $questionService)
    {
        $this->wooppayService   =   $wooppayService;
        $this->questionService  =   $questionService;
        $this->wooppay          =   $wooppay;
    }

    public function request(Request $request)
    {
        if ($request->has(Contract::ID)) {
            $questionId =   (int) $request->input(Contract::ID);
            if ($wooppay = $this->wooppayService->wooppayRepository->firstByQuestionId($questionId)) {
                $status =   $this->wooppay->status($wooppay);
                if (array_key_exists(Contract::STATUS, $status)) {
                    $wooppayStatus  =   (int) $status[Contract::STATUS];
                    if (in_array($wooppayStatus,[19,14])) {
                        $question   =   $this->questionService->questionRepository->update($questionId,[
                            Contract::IS_PAID   =>  true,
                            Contract::STATUS    =>  1
                        ]);
                        QuestionJob::dispatch($question);
                    } elseif (in_array($wooppayStatus,[17,20])) {
                        $question   =   $this->questionService->questionRepository->update($questionId,[
                            Contract::IS_PAID   =>  false,
                            Contract::STATUS    =>  0
                        ]);
                        QuestionJob::dispatch($question);
                    }
                }
            }
        }
    }

    public function back(Request $request)
    {
        Log::info('back', [$request->all()]);
    }
}
