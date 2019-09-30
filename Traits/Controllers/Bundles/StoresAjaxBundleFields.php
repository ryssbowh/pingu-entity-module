<?php

namespace Pingu\Entity\Traits\Controllers\Bundles;

use Pingu\Entity\Contracts\BundleFieldContract;
use Pingu\Entity\Contracts\BundleContract;

trait StoresAjaxBundleFields
{
    use StoresBundleFields;

    /**
     * @inheritDoc
     */
    protected function onStoreFieldSuccess(BundleFieldContract $field, BundleContract $bundle)
    {
        return ['model' => $field, 'message' => 'Field '.$field->field->name." has been created"];
    }
}
