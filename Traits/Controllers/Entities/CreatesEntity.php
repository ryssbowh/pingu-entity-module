<?php

namespace Pingu\Entity\Traits\Controllers\Entities;

use Pingu\Entity\Entities\BaseEntity;
use Pingu\Forms\Support\Form;
use Pingu\Forms\Support\ModelForm;

trait CreatesEntity
{
	/**
	 * Create form for a entity. Model must be set within the route
	 * 
	 * @return view
	 */
	public function create()
	{	
		$entity = $this->getRouteAction('entity');
		
		$this->beforeCreate($entity);
		$form = $this->getCreateForm($entity);
		
		return $this->onCreateFormCreated($form, $entity);
	}

	/**
	 * Callback before create request
	 * 
	 * @param  BaseEntity $entity
	 */
	protected function beforeCreate(BaseEntity $entity){}

	/**
	 * Builds the form for a create request
	 * 
	 * @param  BaseEntity $entity
	 * @return Form
	 */
	protected function getCreateForm(BaseEntity $entity)
	{
		$url = $this->getStoreUri($entity);

		$form = $entity->forms()->create($url);

		$this->afterCreateFormCreated($form, $entity);

		return $form;
	}

	/**
	 * Do stuff after the form is created
	 * 
	 * @param  Form   $form
	 * @param  BaseEntity $entity
	 */
	protected function afterCreateFormCreated(Form $form, BaseEntity $entity){}

	/**
	 * Callback after the create form is created
	 * 
	 * @param  Form       $form
	 * @param  BaseEntity $entity
	 */
	protected function onCreateFormCreated(Form $form, BaseEntity $entity){}

	/**
	 * Get the url for a store request
	 *
	 * @param BaseEntity $entity
	 * @return array
	 */
	protected function getStoreUri(BaseEntity $entity)
	{
		return ['url' => $entity->uris()->make('store', [], $this->getStoreUriPrefix())];
	}

	/**
	 * Prefix the store uri
	 * 
	 * @return string
	 */
	protected function getStoreUriPrefix()
	{
		return '';
	}

}
