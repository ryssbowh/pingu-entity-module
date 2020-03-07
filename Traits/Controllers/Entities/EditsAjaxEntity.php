<?php

namespace Pingu\Entity\Traits\Controllers\Entities;

use Pingu\Entity\Entities\Entity;
use Pingu\Forms\Support\Form;

trait EditsAjaxEntity
{
    use EditsEntity;

    /**
     * @inheritDoc
     */
    protected function onEditFormCreated(Form $form, Entity $model)
    {   
        return ['html' => $form->__toString()];
    }

    /**
     * @inheritDoc
     */
    protected function afterEditFormCreated(Form $form, Entity $model)
    {
        $form->addViewSuggestion('forms.modal')
            ->isAjax()
            ->option('title', 'Edit a '.$model::friendlyName());
    }

    /**
     * @inheritDoc
     */
    protected function getUpdateUriPrefix()
    {
        return ajaxPrefix();
    }
}
