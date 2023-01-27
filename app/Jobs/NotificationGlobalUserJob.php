<?php

namespace App\Jobs;

use App\Domain\Contracts\Contract;
use App\Domain\Helpers\OneSignalHelper;
use App\Domain\Services\NotificationService;
use App\Models\NotificationGlobal;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class NotificationGlobalUserJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected NotificationGlobal $notificationGlobal;
    public function __construct(NotificationGlobal $notificationGlobal)
    {
        $this->notificationGlobal   =   $notificationGlobal;
    }

    public function handle(OneSignalHelper $oneSignalHelper)
    {
        $oneSignalHelper->sendAllByNotificationGlobalId($this->notificationGlobal->{Contract::ID});
        /*if (!$notificationService->notificationRepository->firstWhere([
            Contract::USER_ID   =>  $this->user->{Contract::ID},
            Contract::NOTIFICATION_GLOBAL_ID    =>  $this->notificationGlobal->{Contract::ID},
        ])) {
            $notification   =   $notificationService->notificationRepository->create([
                Contract::USER_ID   =>  $this->user->{Contract::ID},
                Contract::TYPE  =>  2,
                Contract::NOTIFICATION_GLOBAL_ID    =>  $this->notificationGlobal->{Contract::ID},
                Contract::STATUS    =>  true
            ]);
            $oneSignalHelper->send($notification);
        }*/
    }
}
