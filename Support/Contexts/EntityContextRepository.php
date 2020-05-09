<?php

namespace Pingu\Core\Support\Contexts;

use Pingu\Core\Support\Contexts\ObjectContextRepository;
use Pingu\Entity\Http\Contexts\CreateEntityRouteContext;

class EntityContextRepository extends ObjectContextRepository
{
    public function __construct(array $contexts)
    {
        $this->add(CreateEntityRouteContext::class);
        parent::__construct($contexts);
    }
}