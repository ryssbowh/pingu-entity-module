<?php

namespace Pingu\Entity\Traits\Controllers\Bundles;

use Pingu\Field\Contracts\BundleFieldContract;
use Pingu\Entity\Contracts\BundleContract;
use Pingu\Field\Entities\BundleField;
use Pingu\Field\Http\Requests\StoreBundleFieldRequest;

trait StoresBundleFields
{
    /**
     * Store request
     * 
     * @param StoreBundleFieldRequest $request
     * 
     * @return mixed
     */
    public function storeField(StoreBundleFieldRequest $request, BundleContract $bundle)
    {
        $generic = new BundleField;
        $validated = $request->validated();
        $field = $this->performStoreField($request->getField(), $validated, $bundle);
        return $this->onStoreFieldSuccess($field, $bundle);
    }

    /**
     * Perform store
     * 
     * @param BundleFieldContract $field
     * @param array               $fieldValidated
     * @param array               $genericValidated
     * @param BundleContract      $bundle
     * 
     * @return BundleFieldContract
     */
    protected function performStoreField(BundleFieldContract $field, array $validated, BundleContract $bundle): BundleField
    {
        return BundleField::create($validated, $bundle, $field);
    }

    /**
     * Action when sore is successfull
     * 
     * @param  BundleFieldContract $field
     * @param  BundleContract      $bundle
     * @return mixed
     */
    abstract protected function onStoreFieldSuccess(BundleField $field, BundleContract $bundle);
}
