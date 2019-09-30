<?php

namespace Pingu\Entity\Traits\Controllers\Bundles;

use Pingu\Core\Http\Middleware\EditableModel;
use Pingu\Entity\Contracts\BundleContract;
use Pingu\Entity\Entities\BundleField;
use Pingu\Entity\Http\Requests\UpdateBundleFieldRequest;

trait UpdatesBundleFields
{
    /**
     * Update request
     * 
     * @param  UpdateBundleFieldRequest $request
     * @param  BundleField $field
     * @return mixed
     */
    public function updateField(UpdateBundleFieldRequest $request, BundleField $field)
    {
        $this->middleware(EditableModel::class, [$field]);
        $bundle = $this->getRouteAction('bundle');
        $field = $this->performFieldUpdate($field, $request->validated());
        return $this->onUpdateFieldSuccess($field);
    }

    /**
     * Perform update
     * 
     * @param  BundleField $field
     * @param  array       $validated
     * 
     * @return BundleField
     */
    protected function performFieldUpdate(BundleField $field, array $validated)
    {
        $field->instance->saveWithRelations($validated);
        return $field;
    }

    /**
     * Action when update is successfull
     * 
     * @param  BundleField $field
     * 
     * @return mixed
     */
    abstract protected function onUpdateFieldSuccess(BundleField $field);
}
