<?php

namespace Pingu\Entity\Traits\Controllers\Bundles;

use Pingu\Field\Entities\BundleField;

trait UpdatesAjaxBundleFields
{
    use UpdatesBundleFields;

    /**
     * @inheritDoc
     */
    protected function onUpdateFieldSuccess(BundleField $field)
    {
        return ['model' => $field, 'message' =>'Field '.$field->name.' has been updated'];
    }
}
