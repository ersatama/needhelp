<?php

namespace App\Http\Controllers\Api;

use App\Domain\Contracts\Contract;
use App\Domain\Contracts\ErrorContract;
use App\Domain\Services\NotificationService;
use App\Http\Controllers\Controller;
use App\Http\Resources\Notification\NotificationCollection;
use App\Http\Resources\Notification\NotificationResource;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class NotificationController extends Controller
{
    protected NotificationService $notificationService;
    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService  =   $notificationService;
    }

    /**
     * getByUserId - Notification
     *
     * @group Notification
     */
    public function getByUserId($userId)
    {
        return 'hello world!';
        return new NotificationCollection($this->notificationService->notificationRepository->getByUserId($userId));
    }

    /**
     * firstById - Notification
     *
     * @group Notification
     */
    public function firstById($id): Response|NotificationResource|Application|ResponseFactory
    {
        if ($notification = $this->notificationService->notificationRepository->firstById($id)) {
            $this->notificationService->notificationRepository->update($id,[
                Contract::STATUS    =>  false
            ]);
            return new NotificationResource($notification);
        }
        return response(ErrorContract::NOT_FOUND, 404);
    }
}
