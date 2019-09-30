<?php

namespace Pingu\Entity\Traits\Controllers\Bundles;

use Pingu\Entity\Contracts\BundleContract;
use Pingu\Entity\Entities\BundleField;
use Pingu\Forms\Support\Form;

trait EditsAjaxBundleFields
{
    use EditsBundleFields;
    
    /**
     * @inheritDoc
     */
    protected function onEditFieldSuccess(Form $form, BundleField $field)
    {
        $form->addViewSuggestion('forms.modal')
            ->isAjax()
            ->removeField('weight')
            ->option('title', 'Edit field '.$field->instance->name);
        return ['form' => $form->renderAsString()];
    }

    /**
     * update uri
     * 
     * @param  BundleField $field
     * 
     * @return array
     */
    protected function getUpdateFieldUri(BundleContract $bundle, BundleField $field)
    {
        return ['url' => $bundle->bundleUris()->make('updateField', [$field], ajaxPrefix())];
    }
}
