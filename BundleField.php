<?php 

namespace Pingu\Entity;

use Illuminate\Http\Request;
use Pingu\Core\Exceptions\ClassException;
use Pingu\Entity\Contracts\BundleFieldContract;
use Pingu\Entity\Contracts\EntityContract;
use Pingu\Entity\Entities\BundleField as BundleFieldModel;
use Pingu\Entity\Exceptions\BundleFieldException;
use Pingu\Forms\Contracts\Models\FormableContract;
use Pingu\Forms\Exceptions\ModelNotFormable;

class BundleField
{
	protected $bundleFields = [];

	/**
	 * Registers a type of bundle field
	 * 
	 * @param  BundleFieldContract $class
	 * 
	 * @throws BundleFieldException
	 */
	public function registerBundleField(BundleFieldContract $class)
	{
		$impl = class_implements($class);
		$name = $class::getMachineName();
		if(isset($this->bundleFields[$name])){
			throw BundleFieldException::registered($name, $class, $this->bundleFields[$name]);
		}
		$this->bundleFields[$name] = $class;
	}

	/**
	 * Registers multiple bundle fields
	 * 
	 * @param  array  $fields
	 */
	public function registerBundleFields(array $fields)
	{
		foreach($fields as $class){
			$this->registerBundleField($class);
		}
	}

	/**
	 * Get all registered bundle fields
	 * 
	 * @return array
	 */
	public function getRegisteredBundleFields()
	{
		return $this->bundleFields;
	}

	/**
	 * Get a registered bundle field class name
	 * 
	 * @param  string $name
	 * @return string
	 * 
	 * @throws  BundleFieldException
	 * @throws  ModelNotFormable
	 */
	public function getRegisteredBundleField(string $name)
	{
		if(!isset($this->bundleFields[$name])){
			throw BundleFieldException::notRegistered($name);
		}
		return new $this->bundleFields[$name];
	}
}