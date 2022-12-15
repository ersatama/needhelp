<?php

namespace App\Http\Controllers\Api;

use App\Domain\Contracts\Contract;
use App\Domain\Contracts\ErrorContract;
use App\Domain\Requests\Question\CreateRequest;
use App\Domain\Services\QuestionService;
use App\Http\Controllers\Controller;
use App\Http\Resources\Question\QuestionCollection;
use App\Http\Resources\Question\QuestionResource;
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
        $notification   =   $this->questionService->questionRepository->create($createRequest->checked());
        return new QuestionResource($notification);
    }
}
