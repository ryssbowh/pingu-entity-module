<?php

namespace Pingu\Entity\Support\Actions;

use Pingu\Core\Support\Actions\BaseActionRepository;
use Pingu\Entity\Support\Entity;

class BaseEntityActions extends BaseActionRepository
{
    /**
     * Constructor. Will add the base entity actions
     * 
     * @param Entity $entity
     */
    public function __construct()
    {
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
