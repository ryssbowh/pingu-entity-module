<?php 

namespace Pingu\Entity;

use Pingu\Entity\Contracts\BundleContract;
use Pingu\Entity\Contracts\EntityContract;
use Pingu\Entity\Entities\BundleField;
use Pingu\Entity\Exceptions\ClassException;
use Pingu\Entity\Exceptions\EntityBundleException;
use Pingu\Entity\Exceptions\EntityException;

class Entity
{	
	protected $bundles = [];
	protected $entities = [];

	public function registerBundle(BundleContract $bundle)
	{
		if($this->isBundleRegistered($bundle->bundleName())){
			throw EntityBundleException::registered($bundle);
		}
		$this->bundles[$bundle->bundleName()] = $bundle;
		$bundle->bundleRoutes()->registerRoutes();
	}

	public function isBundleRegistered(string $name)
	{
		return isset($this->bundles[$name]);
	}

	public function getRegisteredBundle(string $name)
	{
		if(!$this->isBundleRegistered($name)){
			throw EntityBundleException::notRegistered($name);
		}
		return $this->bundles[$name];
	}

	public function allRegisteredBundles()
	{
		return $this->bundles;
	}

	public function registerEntity(EntityContract $entity)
	{
		if($this->isEntityRegistered($entity->entityType())){
			throw EntityException::registered($entity);
		}
		$this->entities[$entity->entityType()] = $entity;
		//Register entity route slug
		\ModelRoutes::registerSlugFromObject($entity);
		//register entity routes
		$entity->routes()->registerRoutes();
	}

	public function isEntityRegistered(string $name)
	{
		return isset($this->entities[$name]);
	}

	public function getRegisteredEntity(string $name)
	{
		if(!$this->isEntityRegistered($name)){
			throw EntityException::notRegistered($name);
		}
		return $this->entities[$name];
	}
}