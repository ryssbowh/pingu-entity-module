<?php

namespace Pingu\Entity\Traits\Controllers\Bundles;

use Pingu\Entity\Contracts\BundleFieldContract;
use Pingu\Entity\Contracts\BundleContract;
use Pingu\Forms\Support\Form;

trait CreatesAdminBundleFields
{
    use CreatesBundleFields;

    protected function onCreateFieldSuccess(Form $form, BundleContract $bundle, BundleFieldContract $field)
    {
        return $this->getCreateFieldsView($form, $bundle, $field);
    }

    /**
     * Get the view for a create request
     *
     * @param  Form $form
     * @param  Collection $fields
     * @param  BundleContract $bundle
     * @return view
     */
    protected function getCreateFieldsView(Form $form, BundleContract $bundle, BundleFieldContract $field)
    {
        $with = [
            'bundle' => $bundle,
            'form' => $form,
            'fieldType' => $field
        ];

        $this->addVariablesToCreateFieldsView($with, $bundle, $field);
        
        return view($this->getCreateFieldsViewName($bundle))->with($with);
    }

    /**
     * View name for creating a field
     *
     * @param BundleContract $bundle
     * @return string
     */
    protected function getCreateFieldsViewName(BundleContract $bundle)
    {
        return 'entity::createField';
    }

    /**
     * Callback to add variables to the view
     *
     * @param array &$with
     * @param BundleContract $bundle
     * @param BundleFieldContract $field
     */
    protected function addVariablesToCreateFieldsView(array &$with, BundleContract $bundle, BundleFieldContract $field){}

    /**
     * Store uri
     * 
     * @param  BundleContract $bundle
     * @return array
     */
    protected function getStoreFieldUri(BundleContract $bundle): array
    {
        return ['url' => $bundle->bundleUris()->make('storeField', $bundle, adminPrefix())];
    }
}
