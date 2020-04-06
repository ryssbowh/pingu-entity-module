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

    /**
     * @inheritDoc
     */
    public function view(string $field)
    {
        $class = \FormField::getRegisteredOptions($field);
        $options = new $class;
        return $options;
    }

    /**
     * @inheritDoc
     */
    public function validateOptions(Request $request, string $field)
    {
        $class = \FormField::getRegisteredOptions($field);
        $options = new $class;
        $options->validate($request);
        return $options;
    }

    /**
     * @inheritDoc
     */
    public function onPatchFieldLayoutSuccess(BundleContract $bundle)
    {
        return ['message' => 'Layout has been saved'];
    }

    /**
     * @inheritDoc
     */
    public function onFieldLayoutOptionsSuccess(Form $form)
    {
        $form->option('title', 'Edit Options');
        return ['html' => $form->render()];
    }
}