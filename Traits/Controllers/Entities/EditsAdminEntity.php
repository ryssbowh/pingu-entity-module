<?php

namespace Pingu\Entity\Traits\Controllers\Entities;

use Pingu\Entity\Entities\BaseEntity;
use Pingu\Forms\Support\Form;

trait EditsAdminEntity
{
	use EditsEntity;

	/**
	 * Return the view for an edit request
	 * @param  Form $form
	 * @param  BaseEntity $entity 
	 * @return view
	 */
	protected function onEditFormCreated(Form $form, BaseEntity $entity)
	{
		\ContextualLinks::addFromObject($entity);
		$with = [
			'form' => $form,
			'entity' => $entity,
		];
		$this->addVariablesToEditView($with, $entity);
		return view($this->getEditViewName($entity))->with($with);
	}

	/**
	 * @inheritDoc
	 */
	protected function afterEditFormCreated(Form $form, BaseEntity $entity){}

	/**
	 * View name for editing models
	 *
	 * @param BaseEntity $entity
	 * @return string
	 */
	protected function getEditViewName(BaseEntity $entity)
	{
		return 'entity::editEntity';
	}

	/**
	 * Adds variables to the edit view
	 * 
	 * @param array     &$with
	 * @param Basemodel $entity
	 */
	protected function addVariablesToEditView(array &$with, BaseEntity $entity){}

	/**
	 * @inheritDoc
	 */
	protected function getUpdateUriPrefix()
	{
		return adminPrefix();
	}

}
