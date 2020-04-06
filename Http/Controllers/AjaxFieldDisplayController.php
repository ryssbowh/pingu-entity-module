<?php 

namespace Pingu\Entity\Http\Controllers;

use Illuminate\Http\Request;
use Pingu\Core\Http\Controllers\BaseController;
use Pingu\Entity\Contracts\BundleContract;
use Pingu\Entity\Entities\DisplayField;
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
    public function validateOptions(Request $request, $displayer)
    {
        $fieldDisplay = DisplayField::findOrfail($this->requireParameter('_display'));
        $displayerClass = \FieldDisplayer::getDisplayer($displayer);
        $displayer = new $displayerClass($fieldDisplay);
        $displayer->options()->validate($request);
        return $displayer;
    }

    /**
     * @inheritDoc
     */
    public function onPatchFieldLayoutSuccess(BundleContract $bundle)
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
    public function onFieldLayoutOptionsSuccess(Form $form)
    {
        $form->option('title', 'Edit Options');
        return ['html' => $form->render()];
    }
}