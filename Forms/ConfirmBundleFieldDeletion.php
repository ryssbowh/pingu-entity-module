<?php

namespace Pingu\Entity\Forms;

use Pingu\Entity\Entities\BundleField;
use Pingu\Forms\Support\Fields\Link;
use Pingu\Forms\Support\Fields\Submit;
use Pingu\Forms\Support\Form;

class ConfirmBundleFieldDeletion extends Form
{
	/**
	 * Bring variables in your form through the constructor :
	 */
	public function __construct(BundleField $field, array $url)
	{
		$this->field = $field;
		$this->url = $url;
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
			'submit' => [
				'field' => Submit::class,
				'options' => [
					'label' => 'Confirm'
				]
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
		return "DELETE";
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
	 * only alphanumeric and hyphens
	 * 
	 * @return string
	 */
	public function name()
	{
		return 'delete-bundle-field';
	}

}