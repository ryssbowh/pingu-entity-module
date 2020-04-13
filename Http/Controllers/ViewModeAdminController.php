<?php 

namespace Pingu\Entity\Http\Controllers;

use Pingu\Entity\Http\Controllers\AdminEntityController;

class ViewModeAdminController extends AdminEntityController
{
    /**
     * Indexes models
     * 
     * @return mixed
     */
    public function index()
    {
        $entity = $this->getRouteAction('entity');

        $createUrl = $entity::uris()->make('create', [], adminPrefix());
        $with = [
            'entities' => \ViewMode::allObjects(),
            'entity' => $entity,
            'viewModes' => \ViewMode::allNonDefault(),
            'createUrl' => $createUrl,
            'mapping' => \ViewMode::getMapping()
        ];
        return $this->renderEntityView($this->getIndexViewNames($entity), $entity, 'index', $with);
    }
}