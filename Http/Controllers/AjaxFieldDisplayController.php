<?php 

namespace Pingu\Entity\Http\Controllers;

use Illuminate\Http\Request;
use Pingu\Core\Http\Controllers\BaseController;
use Pingu\Entity\Contracts\BundleContract;
use Pingu\Entity\Traits\Controllers\Display\EditsFieldDisplayOptions;
use Pingu\Entity\Traits\Controllers\Display\PatchesFieldDisplay;
use Pingu\Field\Support\FieldDisplayer;
use Pingu\Forms\Support\Form;

class AjaxFieldDisplayController extends BaseController
{
    use PatchesFieldDisplay,
        EditsFieldDisplayOptions;

        /**
         * View request
         * 
         * @param string $displayer
         * 
         * @return array
         */
    public function view(FieldDisplayer $displayer)
    {
        return $displayer;
    }

    /**
     * Validate some displayer options
     * 
     * @param Request $request
     * @param string  $displayer
     * 
     * @return array
     */
    public function validateOptions(Request $request, FieldDisplayer $displayer)
    {
        $displayer->options()->validate($request);
        return $displayer;
    }

    /**
     * @inheritDoc
     */
    public function onPatchFormLayoutSuccess(BundleContract $bundle)
    {
        return ['message' => 'Display has been saved'];
    }

    /**
     * Returns a form to edit some displayer options
     * 
     * @param Form   $form
     * 
     * @return array 
     */
    public function onFormLayoutOptionsSuccess(Form $form)
    {
        $form->isAjax()
            ->option('title', 'Edit Options')
            ->attribute('autocomplete', 'off');
        return ['html' => $form->__toString()];
    }
}