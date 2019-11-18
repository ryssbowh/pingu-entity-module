<?php

namespace Pingu\Entity\Traits\Controllers\Bundles;

use Pingu\Field\Entities\BundleField;

trait DeletesAjaxBundleFields
{
    use DeletesBundleFields;

    /**
     * @inheritDoc
     */
    protected function onDeleteFieldSuccess(BundleField $field)
    {
        return ['model' => $field, 'message' => 'Field '.$field->name.' has been deleted'];
    }
}
