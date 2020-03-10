<?php

namespace Pingu\Entity\Traits\Controllers\Entities;

use Illuminate\Support\Collection;
use Pingu\Entity\Entities\Entity;
use Pingu\Field\Contracts\HasRevisionsContract;

trait IndexesAdminRevisions
{
    use IndexesRevisions;
    
    /**
     * Indexes models
     * 
     * @return mixed
     */
    public function onIndexRevisionsSuccess(Entity $entity, Collection $revisions)
    {   
        \ContextualLinks::addFromObject($entity);
        return view('pages.revisions.index')->with(
            [
            'revisions' => $revisions,
            'entity' => $entity
            ]
        );
    }
}
