<?php

namespace Pingu\Entity\Traits\Controllers\Entities;

use Pingu\Entity\Support\Entity;
use Pingu\Forms\Support\Form;

trait EditsAdminEntity
{
    use EditsEntity;

    /**
     * Return the view for an edit request
     *
     * @param  Form   $form
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
        return view()->first($this->getEditViewNames($entity), $with);
    }

    /**
     * @inheritDoc
     */
    protected function afterEditFormCreated(Form $form, Entity $entity)
    {
    }

    /**
     * View name for editing models
     *
     * @param  Entity $entity
     * @return string
     */
    protected function getEditViewNames(Entity $entity)
    {
        return ['pages.entities.'.class_machine_name($entity).'.edit', 'pages.entities.edit'];
    }

    /**
     * Adds variables to the edit view
     * 
     * @param array     &$with
     * @param Basemodel $entity
     */
    protected function addVariablesToEditView(array &$with, Entity $entity)
    {
    }

    /**
     * @inheritDoc
     */
    protected function getUpdateUriPrefix()
    {
        return adminPrefix();
    }

}
