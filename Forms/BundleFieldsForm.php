<?php

namespace Pingu\Entity\Forms;

use Pingu\Forms\Support\Fields\Select;
use Pingu\Forms\Support\Fields\Submit;
use Pingu\Forms\Support\Form;

class BundleFieldsForm extends Form
{

	/**
	 * Bring variables in your form through the constructor :
	 */
	public function __construct(array $url)
	{
		$this->url = $url;
		$this->availableFields = [];
        foreach(\BundleField::getRegisteredBundleFields() as $name => $class){
            $this->availableFields[$name] = $class::friendlyName();
        }
		parent::__construct();
	}

	/**
	 * Fields definitions for this form, classes used here
	 * must extend Pingu\Forms\Support\Field
	 * 
	 * @return array
	 */
	public function fields()
	{
		return [
			'type' => [
                'field' => Select::class,
                'options' => [
                	'label' => 'Add new field',
                	'items' => $this->availableFields,
                	'allowNoValue' => false
                ]
            ],
            'submit' => [
            	'field' => Submit::class,
            	'options' => ['label' => 'Submit']
            ]
		];
	}

	/**
	 * Method for this form, POST GET DELETE PATCH and PUT are valid
	 * 
	 * @return string
	 */
	public function method()
	{
		return 'GET';
	}

	/**
	 * Url for this form, valid values are
	 * ['url' => '/foo.bar']
	 * ['route' => 'login']
	 * ['action' => 'MyController@action']
	 * 
	 * @return array
	 * @see https://github.com/LaravelCollective/docs/blob/5.6/html.md
	 */
	public function url()
	{
		return $this->url;
	}

	/**
	 * Name for this form, ideally it would be application unique, 
	 * best to prefix it with the name of the module it's for.
	 * 
	 * @return string
	 */
	public function name()
	{
		return 'add-entity-field';
	}

}