<?php

namespace App\Observers\Question;

use App\Domain\Contracts\Contract;
use App\Events\QuestionEvent;
use App\Jobs\QuestionJob;
use App\Models\Notification;
use App\Models\Question;
use Illuminate\Support\Facades\Log;

class QuestionObserver
{
    /**
     * Handle the Question "created" event.
     *
     * @param Question $question
     * @return void
     */
    public function created(Question $question): void
    {

    }

    /**
     * Handle the Question "updated" event.
     *
     * @param Question $question
     * @return void
     */
    public function updated(Question $question): void
    {
        if (trim($question->{Contract::ANSWER}) !== '' && $question->{Contract::LAWYER_ID}) {
            Notification::create([
                Contract::USER_ID   =>  $question->{Contract::USER_ID},
                Contract::TYPE  =>  1,
                Contract::QUESTION_ID   =>  $question->{Contract::ID},
                Contract::STATUS    =>  true
            ]);
        }
    }

    /**
     * Handle the Question "deleted" event.
     *
     * @param Question $question
     * @return void
     */
    public function deleted(Question $question): void
    {
        //
    }

    /**
     * Handle the Question "restored" event.
     *
     * @param Question $question
     * @return void
     */
    public function restored(Question $question): void
    {
        //
    }

    /**
     * Handle the Question "force deleted" event.
     *
     * @param Question $question
     * @return void
     */
    public function forceDeleted(Question $question): void
    {
        //
    }
}
