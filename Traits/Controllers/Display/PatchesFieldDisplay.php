<?php

namespace Pingu\Entity\Traits\Controllers\Display;

use Illuminate\Http\Request;
use Pingu\Entity\Contracts\BundleContract;
use Pingu\Entity\Entities\DisplayField;

trait PatchesFieldDisplay
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
            $model->label = $data['label'];
            $model->options = json_decode($data['options'], true);
            $model->save();
        }
        return $this->onPatchFieldLayoutSuccess($bundle);
    }
}
