<?php

namespace Pingu\Entity\Http\Contexts;

use Pingu\Core\Http\Contexts\IndexContext;
use Pingu\Core\Renderers\AdminViewRenderer;

class IndexViewModeContext extends IndexContext
{   
    /**
     * @inheritDoc
     */
    public static function scope(): string
    {
        return 'admin.index';
    }

    /**
     * @inheritDoc
     */
    public function getResponse(): string
    {
        $createUrl = $this->object::uris()->make('create', [], adminPrefix());
        $with = [
            'models' => \ViewMode::allObjects(),
            'model' => $this->object,
            'viewModes' => \ViewMode::allNonDefault(),
            'createUrl' => $createUrl,
            'mapping' => \ViewMode::getMapping()
        ];
        $renderer = new AdminViewRenderer($this->getViewNames(), $this->object->identifier(), $with);
        return $renderer->render();
    }
}