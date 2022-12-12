<?php

namespace App\Domain\Services;

use App\Domain\Repositories\Question\QuestionRepositoryInterface;

class QuestionService extends Service
{
    public QuestionRepositoryInterface $notificationRepository;
    public function __construct(QuestionRepositoryInterface $notificationRepository)
    {
        $this->notificationRepository   =   $notificationRepository;
    }
}
