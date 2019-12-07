<?php

namespace Pingu\Entity\Traits\Controllers\Entities;

use Illuminate\Http\Request;
use Illuminate\Validation\Validator;
use Pingu\Entity\Contracts\BundleContract;
use Pingu\Entity\Entities\Entity;

trait StoresEntity
{
    /**
     * Stores a new entity, entity must be set within the route
     * 
     * @return redirect
     */
    public function store(Request $request)
    {
        $entity = $this->getRouteAction('entity');
        $bundle = $this->request->route('bundle');

        if ($bundle) {
            $entity->setBundle($bundle);
        }

        try{
            $this->beforeStore($entity, $bundle);
            $validated = $this->validateStoreRequest($entity, $bundle);
            $this->performStore($entity, $validated);
            $this->afterStoreSuccess($entity);
        }
        catch(\Exception $e){
            return $this->onStoreFailure($entity, $e);
        }

        return $this->onStoreSuccess($entity);
    }

    /**
     * Store the entity
     * 
     * @param Entity $entity
     * @param array  $validated
     */
    protected function performStore(Entity $entity, array $validated)
    {
        $entity->saveWithRelations($validated);
    }

    /**
     * Callback before store request
     *
     * @param Entity $entity
     */
    protected function beforeStore(Entity $entity, ?BundleContract $bundle)
    {
    }

    /**
     * Validates a request and return validated array
     * 
     * @param Entity $entity
     * 
     * @return array
     */
    protected function validateStoreRequest(Entity $entity, ?BundleContract $bundle): array
    {
        $validator = $this->getStoreValidator($entity, $bundle);
        $this->modifyStoreValidator($validator, $bundle);
        $validator->validate();
        $validated = $validator->validated();
        return $entity->validator()->castValues($validated);
    }

    /**
     * Creates the validator for a store request
     * 
     * @return Validator
     */
    protected function getStoreValidator(Entity $entity, ?BundleContract $bundle): Validator
    {
        return $entity->validator()->makeValidator($this->request->except('_token'), false);
    }

    /**
     * Modify the store request validator
     * 
     * @param Validator $validator
     */
    protected function modifyStoreValidator(Validator $validator, ?BundleContract $bundle)
    {

    }

    /**
     * Do stuff after a entity has been stored
     * 
     * @param Entity $entity
     */
    protected function afterStoreSuccess(Entity $entity)
    {

    }

    /**
     * Returns response when store fails
     * 
     * @param Entity     $entity
     * @param \Exception $exception
     * 
     * @return mixed
     */
    protected function onStoreFailure(Entity $entity, \Exception $exception)
    {
        throw $exception;
    }

    /**
     * Returns reponse when store succeeds
     * 
     * @param Entity $entity
     * 
     * @return mixed
     */
    abstract protected function onStoreSuccess(Entity $entity);

}
