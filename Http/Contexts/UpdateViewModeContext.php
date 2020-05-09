<?php

namespace Pingu\Entity\Http\Contexts;

use Pingu\Core\Http\Contexts\UpdateContext;
use Pingu\Field\Contracts\HasFieldsContract;

class UpdateViewModeContext extends UpdateContext
{
    /**
     * @inheritDoc
     */
    public function getValidationRules(HasFieldsContract $model): array
    {
        return $model->fieldRepository()->validationRules()->except('machineName')->toArray();
    }
}