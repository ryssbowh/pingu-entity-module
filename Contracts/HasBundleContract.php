<?php

namespace Pingu\Entity\Contracts;

use Pingu\Entity\Contracts\BundleContract;
use Pingu\Field\Contracts\HasFields;

interface HasBundleContract
{
   
    /**
     * Bundle getter
     * 
     * @return ?BundleContract
     */
    public function bundle(): ?BundleContract;
}