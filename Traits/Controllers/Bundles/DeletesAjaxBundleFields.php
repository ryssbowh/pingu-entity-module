<?php

namespace Pingu\Entity\Traits\Controllers\Bundles;

use Pingu\Entity\Entities\BundleField;

trait DeletesAjaxBundleFields
{
    use DeletesBundleFields;

    /**
     * @inheritDoc
     */
    protected function onDeleteFieldSuccess(BundleField $field)
    {
        return ['model' => $field, 'message' => 'Field '.$field->instance->name.' has been deleted'];
    }
}
