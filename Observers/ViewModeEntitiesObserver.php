<?php

namespace Pingu\Entity\Observers;

use Pingu\Entity\Entities\ViewModesEntities;

class ViewModeEntitiesObserver
{
    /**
     * Empties cache
     * 
     * @param ViewMode $mapping
     */
    public function saved(ViewModesEntities $mapping)
    {
        \ViewMode::forgetMappingCache();
    }

    /**
     * Empties cache
     * 
     * @param ViewModesEntities $mapping
     */
    public function deleted(ViewModesEntities $mapping)
    {
        \ViewMode::forgetMappingCache();
    }
}