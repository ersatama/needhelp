<?php

namespace App\Http\Controllers\Api;

use App\Domain\Contracts\Contract;
use App\Domain\Contracts\ErrorContract;
use App\Domain\Helpers\OneSignalHelper;
use App\Domain\Helpers\Wooppay;
use App\Domain\Requests\Question\CreateRequest;
use App\Domain\Requests\Question\GetRequest;
use App\Domain\Requests\Question\UpdateRequest;
use App\Domain\Services\NotificationService;
use App\Domain\Services\PaymentService;
use App\Domain\Services\QuestionService;
use App\Domain\Services\UserService;
use App\Domain\Services\WooppayService;
use App\Events\QuestionEvent;
use App\Http\Controllers\Controller;
use App\Http\Resources\Question\QuestionCollection;
use App\Http\Resources\Question\QuestionResource;
use App\Jobs\QuestionJob;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class QuestionController extends Controller
{
    protected QuestionService $questionService;
    protected UserService $userService;
    protected PaymentService $paymentService;
    protected WooppayService $wooppayService;
    protected Wooppay $wooppay;
    protected NotificationService $notificationService;
    protected OneSignalHelper $oneSignalHelper;

    public function __construct(QuestionService $questionService, UserService $userService, PaymentService $paymentService, WooppayService $wooppayService, Wooppay $wooppay, NotificationService $notificationService, OneSignalHelper $oneSignalHelper)
    {
        $this->questionService  =   $questionService;
        $this->userService      =   $userService;
        $this->paymentService   =   $paymentService;
        $this->wooppayService   =   $wooppayService;
        $this->wooppay          =   $wooppay;
        $this->notificationService  =   $notificationService;
        $this->oneSignalHelper  =   $oneSignalHelper;
    }

    /**
     * @hideFromAPIDocumentation
     * get - Questions
     *
     * @group Questions
     * @throws ValidationException
     */
    public function get(GetRequest $getRequest): Response|Application|ResponseFactory
    {
        $data   =   $getRequest->checked();
        return response([
            Contract::COUNT =>  $this->questionService->questionRepository->countQuestion($data),
            Contract::DATA  =>  new QuestionCollection($this->questionService->questionRepository->getWhere($data))
        ],200);
    }

    /**
     * @hideFromAPIDocumentation
     * averageBetweenClosed - Questions
     *
     * @group Questions
     */
    public function averageBetweenClosed($start, $end): array
    {
        return $this->questionService->questionRepository::averageBetweenClosed($start, $end);
    }

    /**
     * @hideFromAPIDocumentation
     * countDateAverageBetweenClosed - Questions
     *
     * @group Questions
     * @throws Exception
     */
    public function countDateAverageBetweenClosed($lawyerId, $start, $end): array
    {
        return $this->questionService->questionRepository::countDateAverageBetweenClosed($lawyerId, $start, $end);
    }

    /**
     * @hideFromAPIDocumentation
     * countLawyerDateBetweenClosed - Questions
     *
     * @group Questions
     */
    public function countDateLawyerBetweenClosed($lawyerId, $start, $end)
    {
        return $this->questionService->questionRepository::countDateLawyerBetweenClosed($lawyerId, $start, $end);
    }

    /**
     * @hideFromAPIDocumentation
     * countDateBetweenClosed - Questions
     *
     * @group Questions
     */
    public function countDateBetweenClosed($start,$end)
    {
        return $this->questionService->questionRepository::countDateBetweenClosed($start,$end);
    }

    /**
     * @hideFromAPIDocumentation
     * countDateBetween - Questions
     *
     * @group Questions
     */
    public function countDateBetween($start,$end)
    {
        $this->questionService->questionRepository::countDateBetween($start,$end);
    }

    /**
     * @hideFromAPIDocumentation
     * priceDateBetween - Questions
     *
     * @group Questions
     */
    public function priceDateBetween($start,$end)
    {
        return $this->questionService->questionRepository::priceDateBetween($start,$end);
    }

    /**
     * getByUserId - Questions
     *
     * @group Questions
     */
    public function getByUserId($userId): QuestionCollection
    {
        return new QuestionCollection($this->questionService->questionRepository->getByUserId($userId));
    }

    /**
     * firstById - Questions
     *
     * @group Questions
     */
    public function firstById($id): Response|QuestionResource|Application|ResponseFactory
    {
        if ($notification = $this->questionService->questionRepository->firstById($id)) {
            $notification   =   $this->questionService->questionRepository->update($notification->{Contract::ID},[
                    Contract::IS_NEW    =>  false
                ]);
            return new QuestionResource($notification);
        }
        return response(ErrorContract::NOT_FOUND, 404);
    }

    /**
     * create - Questions
     *
     * @group Questions
     * @throws ValidationException
     */
    public function create(CreateRequest $createRequest): Response|QuestionResource|Application|ResponseFactory
    {
        if ($question = $this->questionService->questionRepository->create($createRequest->checked())) {
            $user   =   $this->userService->userRepository->firstById($question->{Contract::USER_ID});
            $wooppayInvoice = $this->wooppay->invoice($question, $user);
            if ($user && $question->{Contract::PAYMENT_ID} === 1 && $wooppayInvoice) {
                $this->wooppayService->invoiceCreate($question, $wooppayInvoice);
                return new QuestionResource($question);
            }
            return response(ErrorContract::ERROR_PAYMENT, 400);
        }
        return response(ErrorContract::ERROR, 400);
    }

    /**
     * update - Questions
     *
     * @group Questions
     * @throws ValidationException
     */
    public function update($id, UpdateRequest $updateRequest): Response|QuestionResource|Application|ResponseFactory
    {
        $data   =    $updateRequest->checked();

        if ($question = $this->questionService->questionRepository->firstById($id)) {
            if ($question->{Contract::ANSWER} && $question->{Contract::ANSWERED_AT}) {
                return response(ErrorContract::QUESTION_ALREADY_ANSWERED, 400);
            } elseif ($question->{Contract::STATUS} !== 2) {
                if (array_key_exists(Contract::ANSWER, $data)) {
                    $data[Contract::STATUS] =   2;
                }
                $question   =   $this->questionService->questionRepository->update($id, $data);
                if (array_key_exists(Contract::ANSWER, $data)) {
                    $notification   =   $this->notificationService->notificationRepository->create([
                        Contract::USER_ID   =>  $question->{Contract::USER_ID},
                        Contract::TYPE  =>  1,
                        Contract::QUESTION_ID   =>  $question->{Contract::ID},
                        Contract::STATUS    =>  true
                    ]);
                    $this->oneSignalHelper->send($notification);
                }
                event(new QuestionEvent($question));
            }
            return new QuestionResource($question);
        }
        return response(ErrorContract::NOT_FOUND, 404);
    }
}
