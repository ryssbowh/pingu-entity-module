<?php

namespace Pingu\Entity\Http\Contexts;

use Pingu\Core\Http\Contexts\CreateContext;
use Pingu\Entity\Support\BundledEntity;

class CreateEntityRouteContext extends CreateContext
{
    /**
     * @inheritDoc
     */
    public function getFormAction(): array
    {
        $replacement = $this->object instanceof BundledEntity ?  $this->object->bundle() : [];
        return ['url' => $this->object->uris()->make('store', $replacement, $this->getRouteScope())];
    }
}