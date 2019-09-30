<?php

namespace Pingu\Entity\Traits\Controllers\Bundles;

use Pingu\Core\Exceptions\ParameterMissing;
use Pingu\Entity\Contracts\BundleFieldContract;
use Pingu\Entity\Contracts\BundleContract;
use Pingu\Entity\Forms\AddBundleFieldForm;

trait CreatesBundleFields
{
    /**
     * Create request
     * 
     * @return mixed
     */
    public function createField()
    {   
        $type = $this->request->input('type', false);
        if(!$type){
            throw new ParameterMissing('type', 'get');
        }
        $bundle = $this->getRouteAction('bundle');
        $url = $this->getStoreFieldUri($bundle);
        $field = \BundleField::getRegisteredBundleField($type);
        $form = new AddBundleFieldForm($field, $url);
        $form->moveFieldUp('name');
        
        return $this->onCreateFieldSuccess($form, $bundle, $field);
    }

    /**
     * Actions when create form is created
     * 
     * @param  Form                 $form
     * @param  BundleContract $bundle
     * @param  BundleFieldContract  $field
     * 
     * @return mixed                            
     */
    abstract protected function onCreateFieldSuccess(Form $form, BundleContract $bundle, BundleFieldContract $field);
}
