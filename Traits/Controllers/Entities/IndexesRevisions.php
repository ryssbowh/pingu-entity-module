<?php

namespace Pingu\Entity\Traits\Controllers\Entities;

use Pingu\Field\Contracts\HasRevisionsContract;

trait IndexesRevisions
{
    /**
     * Indexes models
     * 
     * @return mixed
     */
    public function indexRevisions(HasRevisionsContract $entity)
    {
        return $this->onIndexRevisionsSuccess($entity, $entity->revisionRepository()->all());
    }
}
