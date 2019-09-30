<?php

namespace Pingu\Entity\Contracts;

use Pingu\Entity\Contracts\BundleContract;
use Pingu\Forms\Support\Form;

interface BundleFieldContract{

	/**
	 * Define the field relationship, this needs to be a morphOne which will point to the generic field (model Field)
	 * @return Relation
	 */
	public function field();

	/**
	 * Get the machine name for that field
	 * 
	 * @return string
	 */
	public static function getMachineName();

	/**
	 * Field definiton for that field
	 * 
	 * @return array
	 */
	public function bundleFieldDefinition();

	/**
	 * Validation rules for that field
	 * 
	 * @return string
	 */
	public function bundleFieldValidationRule();

	/**
	 * Validation messages for that field
	 * 
	 * @return array
	 */
	public function bundleFieldValidationMessages();

	/**
	 * Treats the value before it's saved in database
	 * 
	 * @param  mixed $value
	 * @return mixed
	 */
	public function storeValue($value);

	/**
	 * Retrieves the value from db
	 * 
	 * @param  mixed $value
	 * @return mixed
	 */
	public function retrieveValue($value);

	/**
	 * Creates a new field for a bundle
	 * 
	 * @param  array                $genericAttributes attributes for the bundle_fields table
	 * @param  array                $fieldAttributes   attributes for the field
	 * @param  BundleContract $bundle
	 * @return BundleFieldContract
	 */
	// public static function create(array $genericAttributes, array $fieldAttributes, BundleContract $bundle);

}