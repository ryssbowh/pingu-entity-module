<?php

namespace Pingu\Entity\Support\Actions;

use Pingu\Core\Support\Actions;
use Pingu\Entity\Support\Entity;

class BaseEntityActions extends Actions
{
    protected $entity;

    /**
     * Constructor. Will add the base entity actions
     * 
     * @param Entity $entity
     */
    public function __construct(Entity $entity)
    {
        $this->entity = $entity;
        $entityActions = Entity::actions()->all();
        $this->addMany($entityActions);
        $this->replaceMany($this->actions());
    }

    /**
     * @inheritDoc
     */
    protected function actions(): array
    {
        return [];
    }
}
