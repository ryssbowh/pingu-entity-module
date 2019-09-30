<?php

namespace Pingu\Entity\Traits\Controllers\Bundles;

use Pingu\Entity\Contracts\BundleContract;

trait IndexesBundleFields
{
    public function indexFields()
    {
        $bundle = $this->getRouteAction('bundle');

        $this->beforeIndexFields($bundle);

        $fields = $bundle->bundleFields();

        return $this->onIndexFieldsSuccess($bundle, $fields);
    }

    protected function beforeIndexFields(BundleContract $bundle){}
}
