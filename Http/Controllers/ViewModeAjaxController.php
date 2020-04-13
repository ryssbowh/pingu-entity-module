<?php 

namespace Pingu\Entity\Http\Controllers;

use Illuminate\Http\Request;
use Pingu\Core\Http\Controllers\BaseController;
use Pingu\Entity\Entities\ViewMode;
use Pingu\Entity\Entities\ViewModesMapping;
use Pingu\Entity\Http\Controllers\AjaxEntityController;
use Pingu\Entity\Support\Entity;
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
        foreach ($mapping as $viewMode => $objects) {
            $viewModeModel = \ViewMode::get($viewMode);
            $toDelete = array_diff($objects, $models[$viewMode] ?? []);
            $toAdd = array_diff($models[$viewMode] ?? [], $objects);
            foreach ($toDelete as $object) {
                ViewModesMapping::where('view_mode_id', $viewModeModel->id)->where('object', $object)->first()->delete();
            }
            foreach ($toAdd as $object) {
                $map = new ViewModesMapping;
                $map->fill([
                    'object' => $object
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