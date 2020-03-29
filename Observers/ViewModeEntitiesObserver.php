<?php

namespace Pingu\Entity\Observers;

use Pingu\Entity\Entities\ViewModesMapping;

class ViewModeEntitiesObserver
{
    /**
     * Empties cache
     * 
     * @param ViewMode $mapping
     */
    public function saved(ViewModesMapping $mapping)
    {
        \ViewMode::forgetMappingCache();
    }

    /**
     * Empties cache
     * 
     * @param ViewModesMapping $mapping
     */
    public function deleted(ViewModesMapping $mapping)
    {
        \ViewMode::forgetMappingCache();
    }
}