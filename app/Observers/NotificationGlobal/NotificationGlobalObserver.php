<?php

namespace App\Observers\NotificationGlobal;

use App\Jobs\NotificationGlobalJob;
use App\Models\NotificationGlobal;
use Illuminate\Support\Facades\Log;

class NotificationGlobalObserver
{
    public function created(NotificationGlobal $notificationGlobal): void
    {
        NotificationGlobalJob::dispatch($notificationGlobal);
    }

    public function updated(NotificationGlobal $notificationGlobal): void
    {
        //
    }

    public function deleted(NotificationGlobal $notificationGlobal): void
    {
        //
    }

    public function restored(NotificationGlobal $notificationGlobal): void
    {
        //
    }

    public function forceDeleted(NotificationGlobal $notificationGlobal): void
    {
        //
    }
}
