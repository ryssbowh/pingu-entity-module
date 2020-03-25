<?php

namespace Pingu\Entity\Traits\Controllers\Display;

use Illuminate\Http\Request;
use Pingu\Entity\Contracts\BundleContract;
use Pingu\Field\Entities\BundleField;
use Pingu\Field\Entities\DisplayField;
use Pingu\Field\Entities\FormLayout;
use Pingu\Field\Entities\FormLayoutGroup;
use Pingu\Forms\Support\Form;

trait PatchesDisplay
{
    /**
     * Pathes field displays
     * 
     * @param Request        $request
     * @param BundleContract $bundle
     * 
     * @return array
     */
    public function patch(Request $request, BundleContract $bundle)
    {
        $models = $request->post('models', []);
        foreach ($models as $data) {
            $model = DisplayField::findOrFail($data['id']);
            $model->displayer = $data['displayer'];
            $model->weight = $data['weight'];
            $model->hidden = $data['hidden'];
            $model->options = json_decode($data['options'], true);
            $model->save();
        }
        return $this->onPatchFormLayoutSuccess($bundle);
    }
}
