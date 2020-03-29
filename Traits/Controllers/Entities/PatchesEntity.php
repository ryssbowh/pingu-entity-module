<?php

namespace Pingu\Entity\Traits\Controllers\Entities;

use Illuminate\Support\Collection;
use Pingu\Entity\Support\Entity;
use Symfony\Component\HttpKernel\Exception\HttpException;

trait PatchesEntity
{
    public function patch()
    {
        $post = $this->beforePatch($this->request->post());
        if (!isset($post['models'])) {
            return $this->onPatchFailure(new HttpException(422, "'models' must be set for a patch request"));
        }
        $entity = $this->getRouteAction('entity');
        $entities = $this->performPatch($entity, $post['models']);
        $this->afterSuccessfullPatch($entity, $entities);
        return $this->onPatchSuccess($entity, $entities);
    }

    protected function performPatch(Entity $entity, array $modelsData)
    {
        $models = collect();
        foreach ($modelsData as $id => $data) {
            try{
                $item = $entity::find($id);
                if (!$item) {
                    continue;
                }
                $validated = $item->validator()->makeValidator($data, true)->validate();
                $item->saveWithRelations($validated);
                $models[] = $item->refresh();
            }
            catch(\Exception $e){
                return $this->onPatchFailure($e);
            }
        }
        return $models;
    }

    /**
     * Before patching. Returns the post array
     * 
     * @param  array $post
     * @return array
     */
    protected function beforePatch(array $post)
    {
        return $post;
    }

    /**
     * Actions after successfull patch
     * 
     * @param Collection $models
     */
    protected function afterSuccessfullPatch(Entity $entity, Collection $models)
    {
    }

    /**
     * Returns reponse after successfull patch
     * 
     * @param  Collection $models
     * @return mixed
     */
    protected function onPatchSuccess(Entity $entity, Collection $models)
    {
    }

    /**
     * Returns reponse after failed patch
     * 
     * @param \Exception $e
     */
    protected function onPatchFailure(\Exception $e)
    {
        throw $e;
    }

}
