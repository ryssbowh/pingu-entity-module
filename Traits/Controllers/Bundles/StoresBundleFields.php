<?php

namespace Pingu\Entity\Traits\Controllers\Bundles;

use Pingu\Entity\Contracts\BundleFieldContract;
use Pingu\Entity\Contracts\BundleContract;
use Pingu\Entity\Entities\BundleField;
use Pingu\Entity\Http\Requests\StoreBundleFieldRequest;

trait StoresBundleFields
{
    /**
     * Store request
     * 
     * @param  StoreBundleFieldRequest $request
     * 
     * @return mixed
     */
    public function storeField(StoreBundleFieldRequest $request)
    {
        $generic = new BundleField;
        $bundle = $this->getRouteAction('bundle');
        $validated = $request->validated();
        $genericValidated = ['machineName' => $validated['machineName']];
        unset($validated['machineName']);
        $field = $this->performStoreField($request->getField(), $validated, $genericValidated, $bundle);
        return $this->onStoreFieldSuccess($field, $bundle);
    }

    /**
     * Perform store
     * 
     * @param  BundleFieldContract  $field
     * @param  array                $fieldValidated
     * @param  array                $genericValidated
     * @param  BundleContract $bundle
     * 
     * @return BundleFieldContract
     */
    protected function performStoreField(BundleFieldContract $field, array $fieldValidated, array $genericValidated, BundleContract $bundle): BundleFieldContract
    {
        return $field::create($genericValidated, $fieldValidated, $bundle);
    }

    /**
     * Action when sore is successfull
     * 
     * @param  BundleFieldContract  $field
     * @param  BundleContract $bundle
     * @return mixed
     */
    abstract protected function onStoreFieldSuccess(BundleFieldContract $field, BundleContract $bundle);
}
