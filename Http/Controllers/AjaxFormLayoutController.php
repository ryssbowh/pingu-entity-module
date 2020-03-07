<?php 

namespace Pingu\Entity\Http\Controllers;

use Illuminate\Http\Request;
use Pingu\Core\Http\Controllers\BaseController;
use Pingu\Entity\Contracts\BundleContract;
use Pingu\Entity\Traits\Controllers\Layout\EditsFormLayoutOptions;
use Pingu\Entity\Traits\Controllers\Layout\PatchesFormLayout;
use Pingu\Forms\Support\Form;

class AjaxFormLayoutController extends BaseController
{
    use PatchesFormLayout,
        EditsFormLayoutOptions;

    public function view(string $field)
    {
        $class = \FormField::getRegisteredOptions($field);
        $options = new $class;
        return $options;
    }

    public function validateOptions(Request $request, string $field)
    {
        $class = \FormField::getRegisteredOptions($field);
        $options = new $class;
        $options->validate($request);
        return $options;
    }

    public function onPatchFormLayoutSuccess(BundleContract $bundle)
    {
        return ['message' => 'Layout has been saved'];
    }

    public function onFormLayoutOptionsSuccess(Form $form)
    {
        $form->addViewSuggestion('forms.modal')
            ->isAjax()
            ->option('title', 'Edit Options');
        return \Response::json(
            ['html' => $form->__toString()],
            200, 
            ['Cache-Control', 'no-store, no-cache, must-revalidate, post-check=0, pre-check=0']
        );
    }
}