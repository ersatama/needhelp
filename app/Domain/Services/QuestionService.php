<?php

namespace App\Domain\Services;

use App\Domain\Repositories\Question\QuestionRepositoryInterface;

class QuestionService extends Service
{
    public QuestionRepositoryInterface $questionRepository;
    public function __construct(QuestionRepositoryInterface $questionRepository)
    {
        $this->questionRepository   =   $questionRepository;
    }
}
