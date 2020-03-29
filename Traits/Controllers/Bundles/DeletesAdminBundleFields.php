<?php

namespace Pingu\Entity\Traits\Controllers\Bundles;

use Pingu\Entity\Contracts\BundleContract;
use Pingu\Field\Entities\BundleField;
use Pingu\Entity\Forms\ConfirmBundleFieldDeletion;

trait DeletesAdminBundleFields
{
    use DeletesBundleFields;

    /**
     * Confirm delete request
     * 
     * @param  BundleField $field
     * @return view
     */
    public function confirmDeleteField(BundleField $field)
    {
        $bundle = $this->getRouteAction('bundle');
        $url = ['url' => $bundle->bundleUris()->make('deleteField', [$field], adminPrefix())];
        $form = new ConfirmBundleFieldDeletion($field, $url);
        return view()->first(
            $this->getDeleteFieldViewNames($bundle), [
            'form' => $form,
            'field' => $field
            ]
        );
    }

    /**
     * View name for deleting a field
     *
     * @param  BundleContract $bundle
     * @return string
     */
    protected function getDeleteFieldViewNames(BundleContract $bundle)
    {
        return ['pages.bundles.'.$bundle->name().'.deleteField', 'pages.bundles.deleteField'];
    }

    /**
     * @inheritDoc
     */
    protected function onDeleteFieldSuccess(BundleField $field)
    {
        \Notify::success($field->instance::friendlyName().' field '.$field->instance->name.' has been deleted');
        return redirect($field->bundle()->bundleUris()->make('indexFields', [], adminPrefix()));
    }
}
