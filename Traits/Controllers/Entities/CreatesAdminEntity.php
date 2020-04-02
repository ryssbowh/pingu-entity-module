<?php

namespace Pingu\Entity\Traits\Controllers\Entities;

use Pingu\Entity\Support\Entity;
use Pingu\Forms\Support\Form;

trait CreatesAdminEntity
{
    use CreatesEntity;

    /**
     * @inheritDoc
     */
    protected function onCreateFormCreated(Form $form, Entity $entity)
    {
        return $this->getCreateView($form, $entity);
    }

    /**
     * Get the view for a create request
     * 
     * @param Form   $form
     * @param Entity $entity
     *
     * @return view
     */
    protected function getCreateView(Form $form, Entity $entity)
    {
        $with = [
            'form' => $form,
            'entity' => $entity,
            'indexUrl' => $entity::uris()->make('index', $entity, adminPrefix())
        ];
        $this->addVariablesToCreateView($with, $entity);
        return $this->renderEntityView($this->getCreateViewNames($entity), $entity, 'create', $with);
    }

    /**
     * View name for creating models
     *
     * @param Entity $entity
     * 
     * @return string
     */
    protected function getCreateViewNames(Entity $entity)
    {
        return ['pages.entities.'.class_machine_name($entity).'.create', 'pages.entities.create'];
    }

    /**
     * Callback to add variables to the view
     *
     * @param Entity $entity
     * 
     * @param array  &$with
     */
    protected function addVariablesToCreateView(array &$with, Entity $entity)
    {
    }

    /**
     * @inheritDoc
     */
    protected function getStoreUriPrefix()
    {
        return adminPrefix();
    }

}
