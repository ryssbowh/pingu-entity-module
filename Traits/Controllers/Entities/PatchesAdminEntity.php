<?php

namespace Pingu\Entity\Traits\Controllers\Entities;

use Illuminate\Support\Collection;
use Pingu\Entity\Entities\Entity;
use Symfony\Component\HttpKernel\Exception\HttpException;

trait PatchesAdminEntity
{
    use PatchesEntity;

    /**
     * @inheritDoc
     */
    protected function onPatchSuccess(Entity $entity, Collection $entities)
    {
        return redirect($entity::uris()->make('index', [], adminPrefix()));
    }

    /**
     * @inheritDoc
     */
    protected function afterSuccessfullPatch(Entity $entity, Collection $entities)
    {
        \Notify::success($entity::friendlyNames().' have been saved');
    }

    /**
     * @inheritDoc
     */
    protected function onPatchFailure(Entity $entity, \Exception $e)
    {
        if(env('APP_ENV') == 'local') {
            throw $e;
        }
        \Notify::danger('Error while saving : '.$entity::friendlyName());
        return back();
    }
}
