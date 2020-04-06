<?php 

namespace Pingu\Entity\Http\Controllers;

use Illuminate\Http\Request;
use Pingu\Core\Http\Controllers\BaseController;
use Pingu\Entity\Support\Entity;
use Pingu\Entity\Entities\ViewModesMapping;
use Pingu\Entity\Http\Controllers\AjaxEntityController;
use Pingu\Forms\Support\Form;

class ViewModeAjaxController extends AjaxEntityController
{
    /**
     * @inheritDoc
     */
    public function patch()
    {
        $out = [];
        $models = $this->request->post()['models'] ?? [];
        $mapping = \ViewMode::getMapping();
        foreach ($mapping as $viewMode => $entities) {
            $viewModeModel = \ViewMode::get($viewMode);
            $toDelete = array_diff($entities, $models[$viewMode] ?? []);
            $toAdd = array_diff($models[$viewMode] ?? [], $entities);
            foreach ($toDelete as $entity) {
                ViewModesMapping::where('view_mode_id', $viewModeModel->id)->where('object', $entity)->delete();
            }
            foreach ($toAdd as $entity) {
                $map = new ViewModesMapping;
                $map->fill([
                    'object' => $entity
                ])->view_mode()->associate($viewModeModel)->save();
            }
        }
        return ['message' => 'View modes have been saved'];
    }

    /**
     * @inheritDoc
     */
    protected function afterEditFormCreated(Form $form, Entity $entity)
    {
        $form->getElement('machineName')->option('disabled', true);
    }
}