<?php
namespace Pingu\Entity\Forms;

use Pingu\Entity\Contracts\EntityContract;
use Pingu\Forms\Support\Fields\Link;
use Pingu\Forms\Support\Fields\Submit;
use Pingu\Forms\Support\Form;

class EditEntityForm extends Form
{
	protected $entity;
	protected $url;

	/**
	 * Bring variables in your form through the constructor :
	 */
	public function __construct(EntityContract $entity, array $url)
	{
		$this->entity = $entity;
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
		$editFields = $this->entity->getEditFormFields();
		foreach($editFields as $field){
			$def = $this->entity->getFieldDefinitions($field);
			$def['options']['default'] = $this->entity->$field;
			$fields[$field] = $def;
		}
		
        $fields += [
	        '_submit' => [
	        	'field' => Submit::class,
	        ]
        ];
        return $fields;
	}

	/**
	 * Method for this form, POST GET DELETE PATCH and PUT are valid
	 * 
	 * @return string
	 */
	public function method()
	{
		return 'PUT';
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
		return 'create.'.$this->entity::machineName();
	}
}