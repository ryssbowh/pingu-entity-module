<?php

namespace Pingu\Entity\Traits\Controllers\Bundles;

use Illuminate\Support\Collection;
use Pingu\Entity\Contracts\BundleContract;

trait PatchesAdminBundleFields
{
    use PatchesBundleFields;

    /**
     * @inheritDoc
     */
    protected function onPatchFieldsError(BundleContract $bundle, \Exception $e)
    {
        if(env('APP_ENV') == 'local'){
            throw $e;
        }
        \Notify::danger('Error : '.$e->getMessage());
 
        return redirect($bundle->bundleUris()->make('indexFields', [], adminPrefix()));
    }

    /**
     * @inheritDoc
     */
    protected function onPatchFieldsSuccess(BundleContract $bundle, Collection $fields)
    {
        \Notify::success('Fields has been updated');
        return redirect($bundle->bundleUris()->make('indexFields', [], adminPrefix()));
    }
}
