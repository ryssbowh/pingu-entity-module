<?php

namespace Pingu\Entity\Traits\Controllers\Entities;

use Pingu\Entity\Contracts\BundleContract;
use Pingu\Entity\Entities\Entity;
use Pingu\Forms\Support\Form;
use Pingu\Forms\Support\ModelForm;

trait CreatesEntity
{
    /**
     * Create form for a entity. Model must be set within the route
     * 
     * @return view
     */
    public function create()
    {   
        $entity = $this->getRouteAction('entity');
        $bundle = $this->request->route('bundle');

        if ($bundle) {
            $entity->setBundle($bundle);
        }
        
        $this->beforeCreate($entity, $bundle);
        $form = $this->getCreateForm($entity, $bundle);
        
        return $this->onCreateFormCreated($form, $entity);
    }

    /**
     * Callback before create request
     * 
     * @param Entity $entity
     */
    protected function beforeCreate(Entity $entity, ?BundleContract $bundle){}

    /**
     * Builds the form for a create request
     * 
     * @param Entity $entity
     * 
     * @return Form
     */
    protected function getCreateForm(Entity $entity, ?BundleContract $bundle)
    {
        $url = $this->getStoreUri($entity, $bundle);

        $form = $entity->forms()->create([$url, $bundle]);

        $this->afterCreateFormCreated($form, $entity);

        return $form;
    }

    /**
     * Do stuff after the form is created
     * 
     * @param Form   $form
     * @param Entity $entity
     */
    protected function afterCreateFormCreated(Form $form, Entity $entity){}

    /**
     * Callback after the create form is created
     * 
     * @param Form $form
     * 
     * @param Entity $entity
     */
    protected function onCreateFormCreated(Form $form, Entity $entity){}

    /**
     * Get the url for a store request
     *
     * @param Entity $entity
     * 
     * @return array
     */
    protected function getStoreUri(Entity $entity, ?BundleContract $bundle)
    {
        return ['url' => $entity->uris()->make('store', $bundle, $this->getStoreUriPrefix())];
    }

    /**
     * Prefix the store uri
     * 
     * @return string
     */
    protected function getStoreUriPrefix()
    {
        return '';
    }

}
