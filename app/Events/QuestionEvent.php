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

    public int $data;

    public function __construct(Question $question)
    {
        $this->data =   $question->{Contract::ID};
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
