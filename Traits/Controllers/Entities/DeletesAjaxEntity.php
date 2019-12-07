<?php

namespace Pingu\Entity\Traits\Controllers\Entities;

use Pingu\Core\Entities\BaseModel;
use Symfony\Component\HttpKernel\Exception\HttpException;

trait DeletesAjaxEntity
{
    use DeletesEntity;
    
    /**
     * @inheritDoc
     */
    protected function onDeleteSuccess(BaseModel $model)
    {
        return ['message' => $model::friendlyName().' has been deleted'];
    }

    /**
     * @inheritDoc
     */
    protected function onDeleteFailure(BaseModel $model, \Exception $e)
    {
        if(env('APP_ENV') == 'local') {
            throw $e;
        }
        throw new HttpException(422, $model::friendlyName()." couldn't be deleted");
    }
}
