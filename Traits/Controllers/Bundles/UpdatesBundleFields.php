<?php

namespace Pingu\Entity\Traits\Controllers\Bundles;

use Illuminate\Http\Request;
use Pingu\Core\Http\Middleware\EditableModel;
use Pingu\Entity\Contracts\BundleContract;
use Pingu\Field\Entities\BundleField;
use Pingu\Field\Http\Requests\UpdateBundleFieldRequest;

trait UpdatesBundleFields
{
    /**
     * Update request
     * 
     * @param Request $request
     * @param BundleField $field
     * 
     * @return mixed
     */
    public function updateField(Request $request, BundleContract $bundle, BundleField $field)
    {
        $this->middleware(EditableModel::class, [$field]);
        $validated = $field->instance->validator()->validateUpdateRequest($request);
        $field = $this->performFieldUpdate($field, $validated);
        return $this->onUpdateFieldSuccess($field);
    }

    /**
     * Perform update
     * 
     * @param BundleField $field
     * @param array       $validated
     * 
     * @return BundleField
     */
    protected function performFieldUpdate(BundleField $field, array $validated)
    {
        $field->instance->saveWithRelations($validated);
        $field->saveWithRelations($validated);
        return $field;
    }

    /**
     * Action when update is successfull
     * 
     * @param BundleField $field
     * 
     * @return mixed
     */
    abstract protected function onUpdateFieldSuccess(BundleField $field);
}
