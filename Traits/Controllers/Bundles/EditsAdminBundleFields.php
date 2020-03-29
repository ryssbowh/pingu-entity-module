<?php

namespace Pingu\Entity\Traits\Controllers\Bundles;

use Pingu\Entity\Contracts\BundleContract;
use Pingu\Field\Entities\BundleField;
use Pingu\Forms\Support\Form;

trait EditsAdminBundleFields
{
    use EditsBundleFields;
    
    /**
     * @inheritDoc
     */
    protected function onEditFieldSuccess(Form $form, BundleField $field)
    {
        return $this->getEditFieldView($form, $field);
    }

    /**
     * Get the view for a edit field request
     *
     * @param  Form           $form
     * @param  Collection     $fields
     * @param  BundleContract $entity
     * @return view
     */
    protected function getEditFieldView(Form $form, BundleField $field)
    {
        $with = [
            'form' => $form,
            'field' => $field
        ];

        $this->addVariablesToEditFieldView($with, $field);
        
        return view()->first($this->getEditFieldViewNames($bundle), $with);
    }

    /**
     * View names for editing a field
     *
     * @param  BundleContract $bundle
     * @return string
     */
    protected function getEditFieldViewNames(BundleContract $bundle)
    {
        return ['pages.bundles.'.$bundle->name().'.editField', 'pages.bundles.editField'];
    }

    /**
     * Callback to add variables to the view
     *
     * @param array       &$with
     * @param BundleField $field
     */
    protected function addVariablesToEditFieldView(array &$with, BundleField $field)
    {
    }

    /**
     * @inheritDoc
     */
    protected function getUpdateFieldUri(BundleContract $bundle, BundleField $field)
    {
        return ['url' => $bundle::uris()->make('updateField', [$bundle, $field], adminPrefix())];
    }
}
