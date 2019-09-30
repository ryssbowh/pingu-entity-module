<?php

namespace Pingu\Entity\Traits\Controllers\Bundles;

use Illuminate\Support\Collection;
use Pingu\Entity\Contracts\BundleContract;

trait PatchesAjaxBundleFields
{
    use PatchesBundleFields;

    /**
     * @inheritDoc
     */
    protected function onPatchFieldsSuccess(BundleContract $bundle, Collection $fields)
    {
        return ['models' => $fields->toArray(), 'message' => 'Fields have been updated'];
    }
}
