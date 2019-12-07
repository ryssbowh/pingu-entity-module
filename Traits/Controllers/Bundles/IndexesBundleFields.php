<?php

namespace Pingu\Entity\Traits\Controllers\Bundles;

use Pingu\Entity\Contracts\BundleContract;

trait IndexesBundleFields
{
    /**
     * Index fields request
     * 
     * @param  BundleContract $bundle
     * @return mixed
     */
    public function indexFields(BundleContract $bundle)
    {
        $this->beforeIndexFields($bundle);

        $fields = $bundle->fields()->get();

        return $this->onIndexFieldsSuccess($bundle, $fields);
    }

    /**
     * Actions before indexing fields
     * 
     * @param BundleContract $bundle
     */
    protected function beforeIndexFields(BundleContract $bundle)
    {
    }
}
