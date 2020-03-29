<?php

namespace Pingu\Entity\Traits\Controllers\Bundles;

use Pingu\Field\Contracts\BundleFieldContract;
use Pingu\Entity\Contracts\BundleContract;
use Pingu\Forms\Support\Form;

trait CreatesAdminBundleFields
{
    use CreatesBundleFields;

    /**
     * @inheritDoc
     */
    protected function onCreateFieldSuccess(Form $form, BundleContract $bundle, BundleFieldContract $field)
    {
        return $this->getCreateFieldsView($form, $bundle, $field);
    }

    /**
     * Get the view for a create request
     *
     * @param  Form           $form
     * @param  Collection     $fields
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
        
        return view()->first($this->getCreateFieldViewNames($bundle), $with);
    }

    /**
     * View name for creating a field
     *
     * @param  BundleContract $bundle
     * @return string
     */
    protected function getCreateFieldViewNames(BundleContract $bundle)
    {
        return ['pages.bundles.'.$bundle->name().'.createField', 'pages.bundles.createField'];
    }

    /**
     * Callback to add variables to the view
     *
     * @param array               &$with
     * @param BundleContract      $bundle
     * @param BundleFieldContract $field
     */
    protected function addVariablesToCreateFieldsView(array &$with, BundleContract $bundle, BundleFieldContract $field)
    {
    }

    /**
     * @inheritDoc
     */
    protected function getStoreFieldUri(BundleContract $bundle): array
    {
        return ['url' => $bundle::uris()->make('storeField', $bundle, adminPrefix())];
    }
}
