<?php

namespace Pingu\Entity\Traits\Controllers\Bundles;

use Pingu\Field\Entities\BundleField;

trait UpdatesAdminBundleFields
{
    use UpdatesBundleFields;

    /**
     * @inheritDoc
     */
    protected function onUpdateFieldSuccess(BundleField $field)
    {
        \Notify::success($field->instance::friendlyName().' field '.$field->name.' has been edited');
        return redirect($field->bundle()->bundleUris()->make('indexFields', [], adminPrefix()));
    }
}
