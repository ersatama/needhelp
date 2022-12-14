<?php

namespace App\Domain\Services;

use App\Domain\Repositories\UserDeleted\UserDeletedRepositoryInterface;

class UserDeletedService extends Service
{
    public UserDeletedRepositoryInterface $userDeletedRepository;
    public function __construct(UserDeletedRepositoryInterface $userDeletedRepository)
    {
        $this->userDeletedRepository    =   $userDeletedRepository;
    }
}
