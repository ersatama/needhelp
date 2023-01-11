<?php

namespace App\Observers\Notification;

use App\Jobs\OneSignalQuestion;
use App\Models\Notification;

class NotificationObserver
{
    /**
     * Handle the Notification "created" event.
     *
     * @param Notification $notification
     * @return void
     */
    public function created(Notification $notification): void
    {
        OneSignalQuestion::dispatch($notification);
    }

    /**
     * Handle the Notification "updated" event.
     *
     * @param Notification $notification
     * @return void
     */
    public function updated(Notification $notification): void
    {
        //
    }

    /**
     * Handle the Notification "deleted" event.
     *
     * @param Notification $notification
     * @return void
     */
    public function deleted(Notification $notification): void
    {
        //
    }

    /**
     * Handle the Notification "restored" event.
     *
     * @param Notification $notification
     * @return void
     */
    public function restored(Notification $notification): void
    {
        //
    }

    /**
     * Handle the Notification "force deleted" event.
     *
     * @param Notification $notification
     * @return void
     */
    public function forceDeleted(Notification $notification): void
    {
        //
    }
}
