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
        return view('entity::deleteField',[
            'form' => $form,
            'field' => $field
        ]);
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
