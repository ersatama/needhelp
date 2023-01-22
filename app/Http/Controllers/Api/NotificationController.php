<?php

namespace App\Http\Controllers\Api;

use App\Domain\Contracts\Contract;
use App\Domain\Contracts\ErrorContract;
use App\Domain\Helpers\OneSignalHelper;
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
    protected OneSignalHelper $oneSignalHelper;
    public function __construct(NotificationService $notificationService, OneSignalHelper $oneSignalHelper)
    {
        $this->notificationService  =   $notificationService;
        $this->oneSignalHelper      =   $oneSignalHelper;
    }

    /**
     * @hideFromAPIDocumentation
     * onesignal - Notifications
     *
     * @group Notifications
     */
    public function onesignal()
    {
         $this->oneSignalHelper->send($this->notificationService->notificationRepository->firstById(189500));
         return true;
    }

    /**
     * getByUserId - Notification
     *
     * @group Notification
     */
    public function getByUserId($userId): Response|Application|ResponseFactory
    {
        return response([
            Contract::COUNT =>  $this->notificationService->notificationRepository->count([
                Contract::USER_ID   =>  $userId
            ]),
            Contract::UNVIEWED  =>  $this->notificationService->notificationRepository->count([
                Contract::USER_ID   =>  $userId,
                Contract::STATUS    =>  true
            ]),
            Contract::DATA  =>  new NotificationCollection($this->notificationService->notificationRepository->getByUserId($userId))
        ]);
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
