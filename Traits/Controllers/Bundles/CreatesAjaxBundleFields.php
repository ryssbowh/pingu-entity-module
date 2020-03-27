<?php

namespace Pingu\Entity\Traits\Controllers\Bundles;

use Pingu\Entity\Contracts\BundleContract;
use Pingu\Field\Contracts\BundleFieldContract;
use Pingu\Forms\Support\Form;

trait CreatesAjaxBundleFields
{
    use CreatesBundleFields;

    /**
     * @inheritDoc
     */
    protected function onCreateFieldSuccess(Form $form, BundleContract $bundle, BundleFieldContract $field)
    {
        $form->isAjax()
            ->removeElement('weight')
            ->option('title', 'Add a '.$field::friendlyName(). ' field');
        return ['html' => $form->__toString()];
    }

    /**
     * @inheritDoc
     */
    protected function getStoreFieldUri(BundleContract $bundle): array
    {
        return ['url' => $bundle::uris()->make('storeField', $bundle, ajaxPrefix())];
    }
}
