<?php

namespace Pingu\Entity\Observers;

use Pingu\Entity\Entities\ViewMode;

class ViewModeObserver
{
    /**
     * Empties cache
     * 
     * @param ViewMode $viewMode
     */
    public function saved(ViewMode $viewMode)
    {
        \ViewMode::forgetCache();
    }

    /**
     * Empties cache
     * 
     * @param ViewMode $viewMode
     */
    public function deleted(ViewMode $viewMode)
    {
        \ViewMode::forgetCache();
    }

    /**
     * Deletes mapping
     * 
     * @param ViewMode $viewMode
     */
    public function deleting(ViewMode $viewMode)
    {
        $viewMode->entities->each(
            function ($mapping) {
                $mapping->delete();
            }
        );
    }
}