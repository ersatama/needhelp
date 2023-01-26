<?php

namespace App\Jobs;

use App\Events\QuestionEvent;
use App\Models\Question;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class QuestionJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public int $timeout = 1;
    public int $tries = 1;
    public Question $question;

    public function __construct(Question $question)
    {
        $this->question =   $question;
    }

    public function handle(): void
    {
        event(new QuestionEvent($this->question));
    }
}
