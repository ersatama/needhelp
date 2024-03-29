<?php

namespace App\Events;

use App\Domain\Contracts\Contract;
use App\Models\Question;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class QuestionEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public array $data;

    public function __construct(Question $question)
    {
        $this->data =   [
            Contract::ID    =>  $question->{Contract::ID},
            Contract::IS_PAID   =>  $question->{Contract::IS_PAID},
            Contract::STATUS    =>  $question->{Contract::STATUS}
        ];
    }

    public function broadcastOn(): array
    {
        return ['question-channel'];
    }

    public function broadcastAs(): string
    {
        return 'question-event';
    }
}
