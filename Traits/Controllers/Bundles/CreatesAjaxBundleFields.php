<?php

namespace Pingu\Entity\Traits\Controllers\Bundles;

use Pingu\Entity\Contracts\BundleFieldContract;
use Pingu\Entity\Contracts\BundleContract;
use Pingu\Forms\Support\Form;

trait CreatesAjaxBundleFields
{
    use CreatesBundleFields;

    protected function onCreateFieldSuccess(Form $form, BundleContract $bundle, BundleFieldContract $field)
    {
        $form->addViewSuggestion('forms.modal')
            ->isAjax()
            ->removeField('weight')
            ->option('title', 'Add a '.$field::friendlyName(). ' field');
        return ['form' => $form->renderAsString()];
    }

    /**
     * Store uri
     * 
     * @param  BundleContract $bundle
     * @return array
     */
    protected function getStoreFieldUri(BundleContract $bundle): array
    {
        return ['url' => $bundle->bundleUris()->make('storeField', [], ajaxPrefix())];
    }
}
