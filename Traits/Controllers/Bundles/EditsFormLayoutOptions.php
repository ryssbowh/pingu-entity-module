<?php

namespace Pingu\Entity\Traits\Controllers\Bundles;

use Illuminate\Http\Request;
use Pingu\Entity\Contracts\BundleContract;
use Pingu\Field\Entities\BundleField;
use Pingu\Field\Entities\FormLayout;
use Pingu\Forms\Support\Form;

trait EditsFormLayoutOptions
{
    public function formLayoutOptions(Request $request, BundleContract $bundle, FormLayout $layout)
    {
        $options = $layout->options;
        $options->setValues($request->post('values'));
        $action = ['url' => $bundle::uris()->make('validateFormLayoutOptions', [$bundle, $layout], ajaxPrefix())];
        $form = $options->getEditForm($action);
        return $this->onFormLayoutOptionsSuccess($layout, $form);
    }

    public function patchFormLayout(Request $request, BundleContract $bundle)
    {
        $models = $request->post('models', []);
        foreach ($models as $id => $data) {
            $model = FormLayout::find($id);
            $model->fill([
                'group_id' => $data['group'],
                'weight' => $data['weight'],
                'options' => json_decode($data['options']),
                'widget' => $data['widget']
            ])->save();
        }
        return $this->onPatchFormLayoutSuccess($bundle, $models);
    }
}
