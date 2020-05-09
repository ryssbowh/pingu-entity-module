<?php

namespace Pingu\Entity\Http\Contexts;

use Illuminate\Support\Collection;
use Pingu\Core\Http\Contexts\EditContext;

class EditViewModeContext extends EditContext
{
    /**
     * @inheritDoc
     */
    public function getFields(): Collection
    {
        $fields = $this->object->fieldRepository()->all();
        $fields->get('machineName')->option('disabled', true);
        return $fields;
    }
}