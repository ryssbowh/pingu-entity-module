<?php 

namespace Pingu\Entity;

use Pingu\Entity\Contracts\BundleContract;
use Pingu\Entity\Exceptions\EntityBundleException;
use Pingu\Entity\Support\FieldDisplay\FieldDisplayBundle;
use Pingu\Entity\Support\FieldLayout\FieldLayoutBundle;

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
        if ($this->isRegistered($bundle->name())) {
            throw EntityBundleException::registered($bundle);
        }
        $this->bundles[$bundle->name()] = $bundle;
        \Policies::register($bundle, $bundle->getPolicy());
        \FieldLayout::register($bundle, new FieldLayoutBundle($bundle));
        \FieldDisplay::register($bundle, new FieldDisplayBundle($bundle));
    }

    /**
     * Checks if a bundle is registered
     *
     * @param string|BundleContract $name
     * 
     * @return boolean
     */
    public function isRegistered($bundle): bool
    {
        if ($bundle instanceof BundleContract) {
            $bundle = $bundle->name();
        }
        return isset($this->bundles[$bundle]);
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