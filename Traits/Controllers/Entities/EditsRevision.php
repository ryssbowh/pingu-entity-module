<?php

namespace Pingu\Entity\Traits\Controllers\Entities;

use Illuminate\Support\Arr;
use Pingu\Entity\Entities\Entity;
use Pingu\Field\Support\FieldRevision;
use Pingu\Forms\Support\Form;
use Pingu\Forms\Support\ModelForm;

trait EditsRevision
{
    /**
     * Edits a entity, builds a form and send it as string
     * 
     * @param  Entity $entity
     * @return array
     */
    public function editRevision(Entity $entity, int $id)
    {
        $revision = $this->loadRevision($entity, $id);

        $form = $this->getRevisionForm($entity, $revision);

        return $this->onEditRevisionFormCreated($form, $entity);
    }

    protected function loadRevision(Entity $entity, int $id)
    {
        return $entity->revisionRepository()->get($id);
    }

    /**
     * Builds the form for an edit request
     * 
     * @param  Entity $entity 
     * @return FormModel
     */
    protected function getRevisionForm(Entity $entity, FieldRevision $revision)
    {
        $url = Arr::wrap($this->getRestoreRevisionUri($entity, $revision));

        $form = $entity->forms()->editRevision([$url, $entity, $revision]);

        $this->afterEditRevisionFormCreated($form, $entity);

        return $form;
    }

    /**
     * Gets the update uri
     * 
     * @return string
     */
    protected function getRestoreRevisionUri(Entity $entity, FieldRevision $revision)
    {
        return $entity->uris()->make('update', $entity, $this->getRestoreRevisionUriPrefix());
    }

    /**
     * Prefix the update uri
     * 
     * @return string
     */
    protected function getRestoreRevisionUriPrefix()
    {
        return '';
    }

    /**
     * Modify the edit form
     * 
     * @param Form $form
     */
    protected function afterEditRevisionFormCreated(Form $form, Entity $entity, FieldRevision $revision)
    {
    }

    /**
     * Response to client
     * 
     * @return mixed
     */
    protected function onEditRevisionFormCreated()
    {
    }

}
