<?php

namespace Pingu\Entity\Traits\Controllers\Bundles;

use Pingu\Core\Http\Middleware\EditableModel;
use Pingu\Entity\Contracts\BundleContract;
use Pingu\Entity\Entities\BundleField;
use Pingu\Entity\Forms\EditBundleFieldForm;

trait EditsBundleFields
{
    /**
     * Edit request
     * 
     * @param  BundleField $field
     * 
     * @return mixed
     */
    public function editField(BundleField $field)
    {
        $this->middleware(EditableModel::class, [$field]);
        $bundle = $this->getRouteAction('bundle');
        $url = $this->getUpdateFieldUri($bundle, $field);
        $form = new EditBundleFieldForm($field, $url);
        
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
