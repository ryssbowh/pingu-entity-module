<?php

namespace Pingu\Entity\Traits\Controllers\Bundles;

use Illuminate\Http\Request;
use Pingu\Entity\Contracts\BundleContract;
use Pingu\Field\Entities\BundleField;
use Pingu\Field\Entities\FormLayout;
use Pingu\Forms\Support\Form;

trait EditsAjaxFormLayoutOptions
{
    use EditsFormLayoutOptions;

    public function onFormLayoutOptionsSuccess(FormLayout $layout, Form $form)
    {
        $form->addViewSuggestion('forms.modal')
            ->isAjax()
            ->option('title', 'Edit Options');
        return ['form' => $form->__toString()];
    }

    public function validateFormLayoutOptions(Request $request, BundleContract $bundle, FormLayout $layout)
    {
        $options = $layout->options;
        $layout->options->validate($request);
        return $options;
    }

    public function onPatchFormLayoutSuccess(BundleContract $bundle, array $models)
    {
        return ['message' => 'Layout has been saved'];
    }
}
