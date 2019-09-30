<?php

namespace Pingu\Entity\Traits\Controllers\Bundles;

use Pingu\Entity\Contracts\BundleFieldContract;
use Pingu\Entity\Contracts\BundleContract;

trait StoresAdminBundleFields
{
    use StoresBundleFields;

    /**
     * @inheritDoc
     */
    protected function onStoreFieldSuccess(BundleFieldContract $field, BundleContract $bundle)
    {
        \Notify::success($field::friendlyName().' field '.$field->field->machineName.' has been saved');
        return redirect($bundle->bundleUris()->make('indexFields', [], adminPrefix()));
    }
}
