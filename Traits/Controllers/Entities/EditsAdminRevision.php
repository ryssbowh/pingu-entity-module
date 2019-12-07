<?php

namespace Pingu\Entity\Traits\Controllers\Entities;

use Pingu\Entity\Entities\Entity;
use Pingu\Forms\Support\Form;

trait EditsAdminRevision
{
    use EditsRevision;

    /**
     * Return the view for an edit request
     * @param  Form $form
     * @param  Entity $entity 
     * @return view
     */
    protected function onEditRevisionFormCreated(Form $form, Entity $entity)
    {
        \ContextualLinks::addFromObject($entity);
        \ContextualLinks::setActiveLink('revisions');
        $with = [
            'form' => $form,
            'entity' => $entity,
            'revision' => $form->revision()
        ];
        $this->addVariablesToEditRevisionView($with, $entity);
        return view($this->getEditRevisionViewName($entity))->with($with);
    }

    /**
     * @inheritDoc
     */
    protected function afterEditRevisionFormCreated(Form $form, Entity $entity){}

    /**
     * View name for editing models
     *
     * @param Entity $entity
     * @return string
     */
    protected function getEditRevisionViewName(Entity $entity)
    {
        return 'entity::editRevision';
    }

    /**
     * Adds variables to the edit view
     * 
     * @param array     &$with
     * @param Basemodel $entity
     */
    protected function addVariablesToEditRevisionView(array &$with, Entity $entity){}

    /**
     * @inheritDoc
     */
    protected function getRestoreRevisionUriPrefix()
    {
        return adminPrefix();
    }

}
