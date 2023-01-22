<?php

namespace App\Domain\Helpers;

use App\Domain\Contracts\Contract;
use App\Domain\Services\UserService;
use App\Models\Notification;
use Illuminate\Support\Facades\Log;
use OneSignal;

class OneSignalHelper
{
    protected UserService $userService;
    public function __construct(UserService $userService)
    {
        $this->userService  =   $userService;
    }

    public function send(Notification $notification)
    {
        if ($user = $this->userService->userRepository->firstById($notification->{Contract::USER_ID}) ) {
            $title  =   '';
            if ($user->{Contract::LANGUAGE_ID} === 1) {
                $title  =   'На Ваш вопрос пришел ответ от юриста';
            } else if ($user->{Contract::LANGUAGE_ID} === 2) {
                $title  =   'Answer to you question received from lawyer';
            } else {
                $title  =   'Заңгер сіздің сұрағыңызға жауап берді';
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
                $data = null,
                $buttons = null,
                $schedule = null
            );
            return 'success';
        }
        return 'failure';
    }
}
