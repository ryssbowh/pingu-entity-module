<?php

namespace Pingu\Entity\Traits\Controllers\Bundles;

use Pingu\Entity\Contracts\BundleContract;
use Pingu\Field\Entities\BundleField;
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
            ->removeElement('weight')
            ->option('title', 'Edit field '.$field->name);
        return ['form' => $form->__toString()];
    }

    /**
     * @inheritDoc
     */
    protected function getUpdateFieldUri(BundleContract $bundle, BundleField $field)
    {
        return ['url' => $bundle::uris()->make('updateField', [$bundle, $field], ajaxPrefix())];
    }
}
