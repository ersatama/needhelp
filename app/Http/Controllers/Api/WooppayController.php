<?php

namespace App\Http\Controllers\Api;

use App\Domain\Contracts\Contract;
use App\Domain\Helpers\Wooppay;
use App\Domain\Services\NotificationEventService;
use App\Domain\Services\QuestionService;
use App\Domain\Services\WooppayService;
use App\Events\QuestionEvent;
use App\Http\Controllers\Controller;
use App\Jobs\QuestionJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WooppayController extends Controller
{
    protected WooppayService $wooppayService;
    protected QuestionService $questionService;
    protected Wooppay $wooppay;
    protected NotificationEventService $notificationEventService;

    public function __construct(WooppayService $wooppayService, Wooppay $wooppay, QuestionService $questionService, NotificationEventService $notificationEventService)
    {
        $this->wooppayService   =   $wooppayService;
        $this->questionService  =   $questionService;
        $this->wooppay          =   $wooppay;
        $this->notificationEventService =   $notificationEventService;
    }

    public function request(Request $request)
    {
        if ($request->has(Contract::ID)) {
            $questionId =   (int) $request->input(Contract::ID);
            if ($wooppay = $this->wooppayService->wooppayRepository->firstByQuestionId($questionId)) {
                $status =   $this->wooppay->status($wooppay);
                if ($status && array_key_exists(Contract::STATUS, $status)) {
                    $wooppayStatus  =   (int) $status[Contract::STATUS];
                    $question   =   $this->questionService->questionRepository->firstById($questionId);
                    if ($question->{Contract::STATUS} !== 2) {
                        if (in_array($wooppayStatus,[19,14])) {
                            $question   =   $this->questionService->questionRepository->update($questionId,[
                                Contract::IS_PAID   =>  true,
                                Contract::STATUS    =>  1
                            ]);
                            if (!$this->notificationEventService->notificationEventRepository->firstWhere([
                                Contract::QUESTION_ID   =>  $question->{Contract::ID},
                                Contract::IS_PAID   =>  true,
                                Contract::STATUS    =>  1
                            ])) {
                                $this->notificationEventService->notificationEventRepository->create([
                                    Contract::QUESTION_ID   =>  $question->{Contract::ID},
                                    Contract::IS_PAID   =>  true,
                                    Contract::STATUS    =>  1
                                ]);
                                broadcast(new QuestionEvent($question));
                            }
                        } elseif (in_array($wooppayStatus,[17,20])) {
                            $question   =   $this->questionService->questionRepository->update($questionId,[
                                Contract::IS_PAID   =>  false,
                                Contract::STATUS    =>  0
                            ]);
                            if (!$this->notificationEventService->notificationEventRepository->firstWhere([
                                Contract::QUESTION_ID   =>  $question->{Contract::ID},
                                Contract::IS_PAID   =>  false,
                                Contract::STATUS    =>  0
                            ])) {
                                $this->notificationEventService->notificationEventRepository->create([
                                    Contract::QUESTION_ID   =>  $question->{Contract::ID},
                                    Contract::IS_PAID   =>  false,
                                    Contract::STATUS    =>  0
                                ]);
                                broadcast(new QuestionEvent($question));
                            }
                        }
                    }
                } else {
                    Log::info('wooppay-controller-error',[$status]);
                }
            }
        }
    }

    public function back(Request $request)
    {

    }
}
