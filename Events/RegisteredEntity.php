<?php

namespace Pingu\Entity\Events;

use Illuminate\Queue\SerializesModels;
use Pingu\Entity\Entities\Entity;

class RegisteredEntity
{
    use SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Entity $entity)
    {
        $this->entity = $entity;
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
