<?php

namespace Pingu\Entity\Traits\Controllers\Bundles;

use Pingu\Entity\Entities\BundleField;

trait UpdatesAjaxBundleFields
{
    use UpdatesBundleFields;

    /**
     * @inheritDoc
     */
    protected function onUpdateFieldSuccess(BundleField $field)
    {
        return ['model' => $field, 'message' =>'Field '.$field->instance->name.' has been updated'];
    }
}
