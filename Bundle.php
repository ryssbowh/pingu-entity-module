<?php 

namespace Pingu\Entity;

use Pingu\Entity\Contracts\BundleContract;
use Pingu\Entity\Exceptions\EntityBundleException;
use Pingu\Entity\Support\FieldDisplay\FieldDisplayBundle;
use Pingu\Entity\Support\FieldLayout\FieldLayoutBundle;

class Bundle
{
    /**
     * Bundles by identifier
     * @var array
     */
    protected $bundles = [];

    /**
     * Bundles by name
     * @var array
     */
    protected $bundlesByName = [];

    /**
     * Registers a bundle
     * 
     * @param BundleContract $bundle
     * 
     * @throws EntityBundleException
     */
    public function registerBundle(BundleContract $bundle)
    {
        if ($this->isRegistered($bundle->identifier())) {
            throw EntityBundleException::registered($bundle);
        }
        $this->bundles[$bundle->identifier()] = $bundle;
        $this->bundlesByName[$bundle->name()] = $bundle;
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
            $bundle = $bundle->identifier();
        }
        return isset($this->bundles[$bundle]);
    }

    /**
     * Gets a registered bundle by identifer
     * 
     * @param string $identifier
     *
     * @throws EntityBundleException
     * @return BundleContract
     */
    public function get(string $identifier): BundleContract
    {
        if (!$this->isRegistered($identifier)) {
            throw EntityBundleException::notRegistered($identifier);
        }
        return $this->bundles[$identifier];
    }

    /**
     * Gets a registered bundle by name
     * 
     * @param string $name
     *
     * @throws EntityBundleException
     * @return BundleContract
     */
    public function getByName(string $name): BundleContract
    {
        if (!isset($this->bundlesByName[$name])) {
            throw EntityBundleException::notRegistered($name);
        }
        return $this->bundlesByName[$name];
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