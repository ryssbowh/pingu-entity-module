<?php

namespace Pingu\Entity\Observers;

use Pingu\Entity\Entities\ViewModesMapping;

class ViewModeMappingObserver
{
    /**
     * Empties cache
     * 
     * @param ViewModesMapping $mapping
     */
    public function deleted(ViewModesMapping $mapping)
    {
        \ViewMode::forgetMappingCache();
        $mapping->getObject()->fieldDisplay()->deleteForViewMode($mapping->view_mode);
    }

    /**
     * Create display for all fields
     * 
     * @param  ViewModesMapping $mapping
     */
    public function created(ViewModesMapping $mapping)
    {
        \ViewMode::forgetMappingCache();
        $mapping->getObject()->fieldDisplay()->createForViewMode($mapping->view_mode);
    }
}