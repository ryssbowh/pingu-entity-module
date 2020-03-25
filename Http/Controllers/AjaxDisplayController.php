<?php 

namespace Pingu\Entity\Http\Controllers;

use Illuminate\Http\Request;
use Pingu\Core\Http\Controllers\BaseController;
use Pingu\Entity\Contracts\BundleContract;
use Pingu\Entity\Traits\Controllers\Display\EditsDisplayOptions;
use Pingu\Entity\Traits\Controllers\Display\PatchesDisplay;
use Pingu\Forms\Support\Form;

class AjaxDisplayController extends BaseController
{
    use PatchesDisplay,
        EditsDisplayOptions;

        /**
         * View request
         * 
         * @param string $displayer
         * 
         * @return array
         */
    public function view(string $displayer)
    {
        $displayer = \FieldDisplay::getRegisteredDisplayer($displayer);
        $displayer = new $displayer;
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
    public function validateOptions(Request $request, string $displayer)
    {
        $displayer = \FieldDisplay::getRegisteredDisplayer($displayer);
        $displayer = new $displayer;
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
        $form->addViewSuggestion('forms.modal')
            ->isAjax()
            ->option('title', 'Edit Options');
        return ['html' => $form->__toString()];
    }
}