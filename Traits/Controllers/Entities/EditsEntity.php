<?php

namespace Pingu\Entity\Traits\Controllers\Entities;

use Pingu\Entity\Entities\BaseEntity;
use Pingu\Forms\Support\Form;
use Pingu\Forms\Support\ModelForm;

trait EditsEntity
{
	/**
	 * Edits a entity, builds a form and send it as string
	 * 
	 * @param  BaseEntity $entity
	 * @return array
	 */
	public function edit(BaseEntity $entity)
	{
		$this->beforeEdit($entity);
		$form = $this->getEditForm($entity);

		return $this->onEditFormCreated($form, $entity);
	}

	/**
	 * Builds the form for an edit request
	 * 
	 * @param  BaseEntity $entity 
	 * @return FormModel
	 */
	protected function getEditForm(BaseEntity $entity)
	{
		$url = $this->getUpdateUri($entity);
		if(!is_array($url)){
			$url = ['url' => $url];
		}

		$form = $entity->forms()->edit($url);

		$this->afterEditFormCreated($form, $entity);

		return $form;
	}

	/**
	 * Callback before edit request
	 *
	 * @param BaseEntity $entity
	 */
	protected function beforeEdit(BaseEntity $entity){}

	/**
	 * Gets the update uri
	 * 
	 * @return string
	 */
	protected function getUpdateUri(BaseEntity $entity)
	{
		return $entity->uris()->make('update', $entity, $this->getUpdateUriPrefix());
	}

	/**
	 * Prefix the update uri
	 * 
	 * @return string
	 */
	protected function getUpdateUriPrefix()
	{
		return '';
	}

	/**
	 * Modify the edit form
	 * 
	 * @param  Form $form
	 */
	protected function afterEditFormCreated(Form $form, BaseEntity $entity){}

	/**
	 * Response to client
	 * 
	 * @return mixed
	 */
	protected function onEditFormCreated(){}

}
