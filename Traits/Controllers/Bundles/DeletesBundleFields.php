<?php

namespace Pingu\Entity\Traits\Controllers\Bundles;

use Pingu\Core\Http\Middleware\DeletableModel;
use Pingu\Entity\Contracts\BundleContract;
use Pingu\Entity\Entities\BundleField;

trait DeletesBundleFields
{
    /**
     * Delete request
     * 
     * @param  Request $request
     * 
     * @return mixed
     */
    public function deleteField(BundleField $field)
    {
        $this->performDeleteField($field);
        return $this->onDeleteFieldSuccess($field);
    }

    /**
     * perform delete
     * 
     * @param  BundleField $field
     */
    protected function performDeleteField(BundleField $field)
    {
        $field->instance->delete();
        $field->delete();
    }

    /**
     * Action when delete is successfull
     * 
     * @param  BundleField $field
     * 
     * @return mixed
     */
    abstract protected function onDeleteFieldSuccess(BundleField $field);
}
