<?php

namespace App\Jobs;

use App\Domain\Contracts\Contract;
use App\Domain\Helpers\OneSignalHelper;
use App\Domain\Scopes\Page;
use App\Domain\Services\NotificationService;
use App\Domain\Services\UserService;
use App\Models\NotificationGlobal;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class NotificationGlobalJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public int $timeout = 1;
    public int $tries = 1;
    protected NotificationGlobal $notificationGlobal;

    public function __construct(NotificationGlobal $notificationGlobal)
    {
        $this->notificationGlobal   =   $notificationGlobal;
    }

    public function handle(UserService $userService): void
    {
        if ($this->notificationGlobal->{Contract::ROLE} !== Contract::ALL) {
            $users  =   $userService->userRepository->getByRole($this->notificationGlobal->{Contract::ROLE});
        } else {
            $users  =   $userService->userRepository->get();
        }
        $users  =   User::withoutGlobalScope(Page::class)->get();
        foreach ($users as &$user) {
            NotificationGlobalUserJob::dispatch($this->notificationGlobal, $user);
        }
    }
}
