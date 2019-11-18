<?php

namespace Pingu\Entity\Traits\Controllers\Bundles;

use Pingu\Entity\Contracts\BundleContract;
use Pingu\Field\Entities\BundleField;

trait StoresAdminBundleFields
{
    use StoresBundleFields;

    /**
     * @inheritDoc
     */
    protected function onStoreFieldSuccess(BundleField $field, BundleContract $bundle)
    {
        \Notify::success($field::friendlyName().' field '.$field->name.' has been saved');
        return redirect($bundle::uris()->make('indexFields', $bundle, adminPrefix()));
    }
}
