<?php

namespace Pingu\Entity\Traits\Controllers\Bundles;

use Pingu\Entity\Contracts\BundleContract;
use Pingu\Field\Entities\BundleField;

trait StoresAjaxBundleFields
{
    use StoresBundleFields;

    /**
     * @inheritDoc
     */
    protected function onStoreFieldSuccess(BundleField $field, BundleContract $bundle)
    {
        return ['model' => $field, 'message' => 'Field '.$field->name." has been created"];
    }
}
