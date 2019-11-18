<?php

namespace Pingu\Entity\Traits\Controllers\Bundles;

use Pingu\Core\Exceptions\ParameterMissing;
use Pingu\Entity\Contracts\BundleContract;
use Pingu\Field\Contracts\BundleFieldContract;
use Pingu\Field\Forms\CreateBundleFieldForm;

trait CreatesBundleFields
{
    /**
     * Create request
     * 
     * @return mixed
     */
    public function createField(BundleContract $bundle)
    {   
        $type = $this->request->input('type', false);
        if (!$type) {
            throw new ParameterMissing('type', 'get');
        }
        $url = $this->getStoreFieldUri($bundle);
        $field = \Field::getRegisteredBundleField($type);
        $field = new $field;
        $form = $field->forms()->create([$url]);

        return $this->onCreateFieldSuccess($form, $bundle, $field);
    }

    /**
     * Actions when create form is created
     * 
     * @param Form                 $form
     * @param BundleContract $bundle
     * @param BundleFieldContract  $field
     * 
     * @return mixed                            
     */
    abstract protected function onCreateFieldSuccess(Form $form, BundleContract $bundle, BundleFieldContract $field);

    /**
     * Get the store field uri
     * 
     * @param  BundleContract $bundle
     * @return array
     */
    abstract protected function getStoreFieldUri(BundleContract $bundle): array;
}
