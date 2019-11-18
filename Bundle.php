<?php 

namespace Pingu\Entity;

use Pingu\Entity\Contracts\BundleContract;
use Pingu\Entity\Exceptions\EntityBundleException;

class Bundle
{   
    protected $bundles = [];

    /**
     * Registers a bundle
     * 
     * @param BundleContract $bundle
     * 
     * @throws EntityBundleException
     */
    public function registerBundle(BundleContract $bundle)
    {
        if ($this->isRegistered($bundle->bundleName())) {
            throw EntityBundleException::registered($bundle);
        }
        $this->bundles[$bundle->bundleName()] = $bundle;
    }

    /**
     * Checks if a bundle is registered
     *
     * @param string  $name
     * 
     * @return boolean
     */
    public function isRegistered(string $name): bool
    {
        return isset($this->bundles[$name]);
    }

    /**
     * Gets a registered bundle
     * 
     * @param string $name
     *
     * @throws EntityBundleException
     * @return BundleContract
     */
    public function get(string $name): BundleContract
    {
        if (!$this->isRegistered($name)) {
            throw EntityBundleException::notRegistered($name);
        }
        return $this->bundles[$name];
    }

    /**
     * Get all registered bundles
     * 
     * @return array
     */
    public function all(): array
    {
        return $this->bundles;
    }
}