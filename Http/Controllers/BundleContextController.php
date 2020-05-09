<?php

namespace Pingu\Entity\Http\Controllers;

use Pingu\Core\Http\Controllers\BaseController;
use Pingu\Core\Traits\Controllers\HasRouteContexts;
use Pingu\Entity\Contracts\BundleContract;

class BundleContextController extends BaseController
{
    use HasRouteContexts;

    public function indexFields(BundleContract $bundle)
    {
        $context = $this->getRouteContext($bundle, $this->request);
        
        return $context->getResponse();
    }

    public function editField(BundleContract $bundle)
    {
        $context = $this->getRouteContext($bundle, $this->request);
        
        return $context->getResponse();
    }

    public function createField(BundleContract $bundle)
    {
        $context = $this->getRouteContext($bundle, $this->request);
        
        return $context->getResponse();
    }

    public function storeField(BundleContract $bundle)
    {
        $context = $this->getRouteContext($bundle, $this->request);
        
        return $context->getResponse();
    }

    public function updateField(BundleContract $bundle)
    {
        $context = $this->getRouteContext($bundle, $this->request);
        
        return $context->getResponse();
    }

    public function deleteField(BundleContract $bundle)
    {
        $context = $this->getRouteContext($bundle, $this->request);
        
        return $context->getResponse();
    }
}