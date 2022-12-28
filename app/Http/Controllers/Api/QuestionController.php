<?php

namespace App\Http\Controllers\Api;

use App\Domain\Contracts\Contract;
use App\Domain\Contracts\ErrorContract;
use App\Domain\Requests\Question\CreateRequest;
use App\Domain\Requests\Question\GetRequest;
use App\Domain\Requests\Question\UpdateRequest;
use App\Domain\Services\QuestionService;
use App\Http\Controllers\Controller;
use App\Http\Resources\Question\QuestionCollection;
use App\Http\Resources\Question\QuestionResource;
use App\Jobs\QuestionJob;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class QuestionController extends Controller
{
    protected QuestionService $questionService;
    public function __construct(QuestionService $questionService)
    {
        $this->questionService  =   $questionService;
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
        return $this->questionService->questionRepository::countDateBetween($start,$end);
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
    public function create(CreateRequest $createRequest): QuestionResource
    {
        $question   =   $this->questionService->questionRepository->create($createRequest->checked());
        QuestionJob::dispatch($question);
        return new QuestionResource($question);
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
            if ($data[Contract::ANSWER] && $question->{Contract::ANSWERED_AT}) {
                return response(ErrorContract::QUESTION_ALREADY_ANSWERED, 400);
            }
            $question   =   $this->questionService->questionRepository->update($id, $data);
            QuestionJob::dispatch($question);
            return new QuestionResource($question);
        }
        return response(ErrorContract::NOT_FOUND, 404);
    }
}
