<?php

namespace Pingu\Entity\Traits\Controllers\Entities;

use Pingu\Entity\Entities\Entity;
use Pingu\Forms\Support\Form;

trait EditsAdminEntity
{
    use EditsEntity;

    /**
     * Return the view for an edit request
     * @param  Form $form
     * @param  Entity $entity 
     * @return view
     */
    protected function onEditFormCreated(Form $form, Entity $entity)
    {
        \ContextualLinks::addFromObject($entity);
        $with = [
            'form' => $form,
            'entity' => $entity,
        ];
        $this->addVariablesToEditView($with, $entity);
        return view($this->getEditViewName($entity))->with($with);
    }

    /**
     * @inheritDoc
     */
    protected function afterEditFormCreated(Form $form, Entity $entity){}

    /**
     * View name for editing models
     *
     * @param Entity $entity
     * @return string
     */
    protected function getEditViewName(Entity $entity)
    {
        return 'entity::editEntity';
    }

    /**
     * Adds variables to the edit view
     * 
     * @param array     &$with
     * @param Basemodel $entity
     */
    protected function addVariablesToEditView(array &$with, Entity $entity){}

    /**
     * @inheritDoc
     */
    protected function getUpdateUriPrefix()
    {
        return adminPrefix();
    }

}
