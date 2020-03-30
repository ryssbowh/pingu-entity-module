<?php

namespace Pingu\Entity\Traits\Controllers\Entities;

use Pingu\Entity\Support\Entity;
use Pingu\Forms\Support\Form;

trait EditsAjaxEntity
{
    use EditsEntity;

    /**
     * @inheritDoc
     */
    protected function onEditFormCreated(Form $form, Entity $model)
    {   
        return ['html' => $form->render()];
    }

    /**
     * @inheritDoc
     */
    protected function afterEditFormCreated(Form $form, Entity $model)
    {
        $form->option('title', 'Edit a '.$model::friendlyName());
    }

    /**
     * @inheritDoc
     */
    protected function getUpdateUriPrefix()
    {
        return ajaxPrefix();
    }
}
