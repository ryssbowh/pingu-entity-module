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
    protected function performPatch(Entity $entity, array $models)
    {
        $out = [];
        foreach (\ViewMode::get() as $viewMode) {
            $viewMode->entities->each(function ($entity) {
                $entity->delete();
            });
            if (isset($models[$viewMode->id])) {
                foreach ($models[$viewMode->id] as $entity) {
                    $map = new ViewModesMapping;
                    $map->fill([
                        'entity' => $entity
                    ])->view_mode()->associate($viewMode)->save();
                    $out[] = $map;
                }
            }
        }
        return collect($out);
    }

    /**
     * @inheritDoc
     */
    protected function afterEditFormCreated(Form $form, Entity $entity)
    {
        $form->getElement('machineName')->option('disabled', true);
    }

    /**
     * @inheritDoc
     */
    protected function afterCreateFormCreated(Form $form, Entity $entity)
    {
        $field = $form->getElement('machineName');
        $field->classes->add('js-dashify');
        $field->attribute('data-dashifyfrom', 'name');
    }
}