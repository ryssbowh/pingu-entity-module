<?php
namespace Pingu\Entity\Forms;

use Pingu\Entity\Entities\BundleField;
use Pingu\Forms\Support\Fields\Hidden;
use Pingu\Forms\Support\Fields\Link;
use Pingu\Forms\Support\Fields\Submit;
use Pingu\Forms\Support\Form;

class EditBundleFieldForm extends Form
{
	protected $field;
	protected $url;
	/**
	 * Bring variables in your form through the constructor :
	 */
	public function __construct(BundleField $field, array $url = [])
	{
		$this->field = $field;
		$this->url = $url;
		parent::__construct();
	}

	/**
	 * 
	 * @return array
	 */
	public function fields()
	{
		foreach($this->field->getEditFormFields() as $name){
			$fields[$name] = $this->field->getFieldDefinitions($name);
			$fields[$name]['options']['default'] = $this->field->$name;
		}

		foreach($this->field->instance->getEditFormFields() as $name){
			if(isset($fields[$name])){
				throw BundleFieldException::alreadyDefined($this->field->instance, $name);
			}
			$fields[$name] = $this->field->instance->getFieldDefinitions($name);
			$fields[$name]['options']['default'] = $this->field->instance->$name;
		}
		$fields['_submit'] = [
			'field' => Submit::class
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
		return 'edit-bundle-field';
	}
}