<?php

namespace App\Domain\Helpers;

use App\Domain\Contracts\Contract;
use App\Domain\Scopes\Page;
use App\Domain\Services\NotificationGlobalService;
use App\Domain\Services\UserService;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use OneSignal;

class OneSignalHelper
{
    protected UserService $userService;
    protected NotificationGlobalService $notificationGlobalService;
    public function __construct(UserService $userService, NotificationGlobalService $notificationGlobalService)
    {
        $this->userService  =   $userService;
        $this->notificationGlobalService    =   $notificationGlobalService;
    }

    public function send(Notification $notification): void
    {
        if ($user = User::where(Contract::ID, $notification->{Contract::USER_ID})->withoutGlobalScope(Page::class)->first() ) {
            $title  =   '';
            $data   =   [];
            if ($notification->{Contract::TYPE} === 1) {
                $data   =   [
                    Contract::QUESTION_ID   =>  $notification->{Contract::QUESTION_ID},
                ];
                if ($user->{Contract::LANGUAGE_ID} === 1) {
                    $title  =   'На Ваш вопрос пришел ответ от юриста';
                } else if ($user->{Contract::LANGUAGE_ID} === 2) {
                    $title  =   'Answer to you question received from lawyer';
                } else {
                    $title  =   'Заңгер сіздің сұрағыңызға жауап берді';
                }
            } elseif ($notification->{Contract::TYPE} === 2) {
                $notificationGlobal =   $this->notificationGlobalService->notificationGlobalRepository->firstById($notification->{Contract::NOTIFICATION_GLOBAL_ID});
                Log::info('onesignal-notificationGlobal', [$notificationGlobal]);
                if ($user->{Contract::LANGUAGE_ID} === 1) {
                    $title  =   $notificationGlobal->{Contract::TEXT};
                } else if ($user->{Contract::LANGUAGE_ID} === 2) {
                    $title  =   $notificationGlobal->{Contract::TEXT_EN};
                } else {
                    $title  =   $notificationGlobal->{Contract::TEXT_KZ};
                }
                $data   =   [
                    Contract::NOTIFICATION_GLOBAL_ID    =>  $notification->{Contract::NOTIFICATION_GLOBAL_ID},
                ];
            }
            OneSignal::sendNotificationUsingTags(
                $title,
                [
                    [
                        Contract::FIELD =>  Contract::TAG,
                        Contract::KEY   =>  Contract::USER_ID,
                        Contract::RELATION  =>  '=',
                        Contract::VALUE =>  $notification->{Contract::USER_ID},
                    ],
                    [
                        Contract::FIELD =>  Contract::TAG,
                        Contract::KEY   =>  Contract::STATUS,
                        Contract::RELATION  =>  '=',
                        Contract::VALUE =>  1,
                    ],
                ],
                $url = null,
                $data = (object) $data,
                $buttons = null,
                $schedule = null
            );
        } else {
            Log::info('onesignal-helper-error',['user',$notification->{Contract::USER_ID}]);
        }
    }
}
