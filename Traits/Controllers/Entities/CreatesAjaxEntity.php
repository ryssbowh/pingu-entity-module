<?php

namespace Pingu\Entity\Traits\Controllers\Entities;

use Pingu\Entity\Support\Entity;
use Pingu\Forms\Support\Form;

trait CreatesAjaxEntity
{
    use CreatesEntity;

    /**
     * @inheritDoc
     */
    protected function onCreateFormCreated(Form $form, Entity $entity)
    {   
        return ['html' => $form->render()];
    }

    /**
     * @inheritDoc
     */
    protected function afterCreateFormCreated(Form $form, Entity $entity)
    {
        $form->option('title', 'Add a '.$entity::friendlyName());
    }

    /**
     * @inheritDoc
     */
    protected function getStoreUriPrefix()
    {
        return ajaxPrefix();
    }
}