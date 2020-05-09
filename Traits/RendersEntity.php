<?php

namespace Pingu\Entity\Traits;

use Pingu\Core\Contracts\RendererContract;
use Pingu\Entity\Support\Renderers\BaseEntityRenderer;

trait RendersEntity
{  
    /**
     * Get renderer for this object
     * 
     * @return RendererContract
     */
    public function getRenderer(): RendererContract
    {
        return new BaseEntityRenderer($this, ...func_get_args());
    }

    /**
     * @inheritDoc
     */
    public function render($viewMode = null): string
    {
        $viewMode = $viewMode ? \ViewMode::get($viewMode) : \ViewMode::getDefault();
        return $this->getRenderer($viewMode)->render();
    }

    /**
     * @inheritDoc
     */
    public function systemView(): string
    {
        return 'entity@entity';
    }
}