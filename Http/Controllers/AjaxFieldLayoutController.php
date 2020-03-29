<?php 

namespace Pingu\Entity\Http\Controllers;

use Illuminate\Http\Request;
use Pingu\Core\Http\Controllers\BaseController;
use Pingu\Entity\Contracts\BundleContract;
use Pingu\Entity\Traits\Controllers\Layout\EditsFieldLayoutOptions;
use Pingu\Entity\Traits\Controllers\Layout\PatchesFieldLayout;
use Pingu\Forms\Support\Form;

class AjaxFieldLayoutController extends BaseController
{
    use PatchesFieldLayout,
        EditsFieldLayoutOptions;

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

    public function onPatchFieldLayoutSuccess(BundleContract $bundle)
    {
        return ['message' => 'Layout has been saved'];
    }

    public function onFieldLayoutOptionsSuccess(Form $form)
    {
        $form->isAjax()
            ->addViewSuggestion('forms.modal')
            ->option('title', 'Edit Options')
            ->attribute('autocomplete', 'off');
        return ['html' => $form->__toString()];
    }
}