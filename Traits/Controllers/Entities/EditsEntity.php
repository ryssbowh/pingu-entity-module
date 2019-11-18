<?php

namespace Pingu\Entity\Traits\Controllers\Entities;

use Pingu\Entity\Entities\Entity;
use Pingu\Forms\Support\Form;
use Pingu\Forms\Support\ModelForm;

trait EditsEntity
{
    /**
     * Edits a entity, builds a form and send it as string
     * 
     * @param  Entity $entity
     * @return array
     */
    public function edit(Entity $entity)
    {
        $this->beforeEdit($entity);
        $form = $this->getEditForm($entity);

        return $this->onEditFormCreated($form, $entity);
    }

    /**
     * Builds the form for an edit request
     * 
     * @param  Entity $entity 
     * @return FormModel
     */
    protected function getEditForm(Entity $entity)
    {
        $url = $this->getUpdateUri($entity);
        if (!is_array($url)) {
            $url = ['url' => $url];
        }

        $form = $entity->forms()->edit([$url, $entity]);

        $this->afterEditFormCreated($form, $entity);

        return $form;
    }

    /**
     * Callback before edit request
     *
     * @param Entity $entity
     */
    protected function beforeEdit(Entity $entity){}

    /**
     * Gets the update uri
     * 
     * @return string
     */
    protected function getUpdateUri(Entity $entity)
    {
        return $entity->uris()->make('update', $entity, $this->getUpdateUriPrefix());
    }

    /**
     * Prefix the update uri
     * 
     * @return string
     */
    protected function getUpdateUriPrefix()
    {
        return '';
    }

    /**
     * Modify the edit form
     * 
     * @param  Form $form
     */
    protected function afterEditFormCreated(Form $form, Entity $entity){}

    /**
     * Response to client
     * 
     * @return mixed
     */
    protected function onEditFormCreated(){}

}
