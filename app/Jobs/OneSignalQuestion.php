<?php

namespace App\Jobs;

use App\Domain\Helpers\OneSignalHelper;
use App\Models\Notification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class OneSignalQuestion implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected Notification $notification;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Notification $notification)
    {
        $this->notification =   $notification;
    }

    /**
     * Execute the job.
     *
     * @param OneSignalHelper $oneSignalHelper
     * @return void
     */
    public function handle(OneSignalHelper $oneSignalHelper): void
    {
        $oneSignalHelper->send($this->notification);
    }
}
