<?php

namespace Pingu\Entity\Traits\Controllers\Bundles;

use Pingu\Core\Http\Middleware\EditableModel;
use Pingu\Entity\Contracts\BundleContract;
use Pingu\Field\Entities\BundleField;

trait EditsBundleFields
{
    /**
     * Edit request
     * 
     * @param Bundle $bundle
     * @param BundleField $field
     * 
     * @return mixed
     */
    public function editField(BundleContract $bundle, BundleField $field)
    {
        $this->middleware(EditableModel::class, [$field]);
        $url = $this->getUpdateFieldUri($bundle, $field);
        $form = $field->instance->forms()->edit([$url]);
        
        return $this->onEditFieldSuccess($form, $field);
    }

    /**
     * Action when edit form is created
     * 
     * @param  Form        $form
     * @param  BundleField $field
     * @return mixed
     */
    abstract protected function onEditFieldSuccess(Form $form, BundleField $field);

    /**
     * update uri
     * 
     * @param  BundleField $field
     * 
     * @return array
     */
    abstract protected function getUpdateFieldUri(BundleContract $bundle, BundleField $field);

}
