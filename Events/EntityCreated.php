<?php

namespace Pingu\Entity\Events;

use Illuminate\Queue\SerializesModels;
use Pingu\Entity\Support\Entity;

class EntityCreated
{
    use SerializesModels;

    public $entity;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Entity $entity)
    {
        $this->entity;
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
