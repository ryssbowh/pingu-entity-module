<?php

namespace Pingu\Entity\Traits\Controllers\Bundles;

use Illuminate\Support\Collection;
use Pingu\Entity\Contracts\BundleContract;
use Pingu\Entity\Entities\BundleField;
use Symfony\Component\HttpKernel\Exception\HttpException;

trait PatchesBundleFields
{   
    /**
     * Patch fields
     * 
     * @return mixed
     */
    public function patchFields()
    {
        $post = $this->request->post();
        if(!isset($post['models'])){
            return $this->onPatchFieldsFailure($bundle, new HttpException(422, "'models' must be set for a patch request"));
        }
        $bundle = $this->getRouteAction('bundle');
        $post = $this->beforePatchFields($bundle, $post['models']);
        $models = $this->performPatchFields($bundle, $post);
        $this->afterSuccessfullPatchFields($bundle, $models);
        return $this->onPatchFieldsSuccess($bundle, $models);
    }

    /**
     * Perform patch
     * 
     * @param  BundleContract $bundle
     * @param  array                $modelsData
     * @return Collection
     */
    protected function performPatchFields(BundleContract $bundle, array $modelsData)
    {
        $models = collect();
        foreach($modelsData as $id => $data){
            try{
                $item = BundleField::findOrFail($id);
                $validated = $item->validateRequestValues($data, array_keys($data));
                $item->saveWithRelations($validated);
                $models[] = $item->refresh();
            }
            catch(\Exception $e){
                return $this->onPatchFieldsFailure($bundle, $e);
            }
        }
        return $models;
    }

    /**
     * Before patching. Returns the post array
     *
     * @param  BundleContract $bundle
     * @param  array  $post
     * @return array
     */
    protected function beforePatchFields(BundleContract $bundle, array $post){
        return $post;
    }

    /**
     * Returns reponse after failed patch
     *
     * @param  BundleContract $bundle
     * @param  \Exception $e
     */
    protected function onPatchFieldsFailure(BundleContract $bundle, \Exception $e){
        throw $e;
    }

    /**
     * Actions after successfull patch
     *
     * @param  BundleContract $bundle
     * @param  Collection $models
     */
    protected function afterSuccessfullPatchFields(BundleContract $bundle, Collection $models){}

    /**
     * Returns reponse after successfull patch
     *
     * @param  BundleContract $bundle
     * @param  Collection $models
     * @return  mixed
     */
    abstract protected function onPatchFieldsSuccess(BundleContract $bundle, Collection $models);
}
