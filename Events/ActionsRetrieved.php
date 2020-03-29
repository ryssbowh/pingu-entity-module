<?php

namespace Pingu\Entity\Events;

use Illuminate\Queue\SerializesModels;
use Pingu\Entity\Support\Entity;

class ActionsRetrieved
{
    use SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(array $actions, $object)
    {
        $this->actions = $actions;
        $this->object = $object;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}
