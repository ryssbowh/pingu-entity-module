<?php

namespace Pingu\Entity\Traits\Controllers\Bundles;

use Pingu\Core\Exceptions\ParameterMissing;
use Pingu\Entity\Contracts\BundleContract;
use Pingu\Field\Contracts\BundleFieldContract;
use Pingu\Forms\Support\Form;

trait CreatesBundleFields
{
    /**
     * Create request
     * 
     * @return mixed
     */
    public function createField(BundleContract $bundle)
    {   
        $type = $this->requireParameter('type');
        $url = $this->getStoreFieldUri($bundle);
        $field = \Field::getRegisteredBundleField($type);
        $field = new $field;

        $form = $field->forms()->create([$url]);
        $this->afterCreateFieldFormCreated($form, $bundle, $field);

        return $this->onCreateFieldSuccess($form, $bundle, $field);
    }

    /**
     * Actions when create form is created
     * 
     * @param Form                $form
     * @param BundleContract      $bundle
     * @param BundleFieldContract $field
     * 
     * @return mixed                            
     */
    protected function afterCreateFieldFormCreated(Form $form, BundleContract $bundle, BundleFieldContract $field)
    {
    }

    /**
     * Response to request
     * 
     * @param Form                $form
     * @param BundleContract      $bundle
     * @param BundleFieldContract $field
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
