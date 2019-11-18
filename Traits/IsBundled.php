<?php 

namespace Pingu\Entity\Traits;

use Pingu\Entity\Contracts\BundleContract;
use Pingu\Field\Traits\HasBundleFields;

/**
 * This trait is to be used on entities that have a bundle
 */
trait IsBundled
{
    use HasBundleFields;
    
    /**
     * Bundle name getter
     * 
     * @return string
     */
    abstract public function bundleName(): string;
    
    /**
     * Bundle getter
     * 
     * @return ?BundleContract
     */
    public function bundle(): ?BundleContract
    {
        if ($name = $this->bundleName()) {
            return \Bundle::get($this->bundleName());
        }
        return null;
    }
}