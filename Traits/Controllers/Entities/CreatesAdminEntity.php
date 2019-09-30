<?php

namespace Pingu\Entity\Traits\Controllers\Entities;

use Pingu\Entity\Entities\BaseEntity;
use Pingu\Forms\Support\Form;

trait CreatesAdminEntity
{
	use CreatesEntity;

	/**
	 * @inheritDoc
	 */
	protected function onCreateFormCreated(Form $form, BaseEntity $entity)
	{
		return $this->getCreateView($form, $entity);
	}

	/**
	 * Get the view for a create request
	 * 
	 * @param  Form $form
	 * @param  BaseEntity $entity
	 * @return view
	 */
	protected function getCreateView(Form $form, BaseEntity $entity)
	{
		$with = [
			'form' => $form,
			'entity' => $entity,
		];
		$this->addVariablesToCreateView($with, $entity);
		return view($this->getCreateViewName($entity))->with($with);
	}

	/**
	 * View name for creating models
	 *
	 * @param BaseEntity $entity
	 * @return string
	 */
	protected function getCreateViewName(BaseEntity $entity)
	{
		return 'entity::createEntity';
	}

	/**
	 * Callback to add variables to the view
	 *
	 * @param  BaseEntity $entity
	 * @param array &$with
	 */
	protected function addVariablesToCreateView(array &$with, BaseEntity $entity){}

	/**
	 * @inheritDoc
	 */
	protected function getStoreUriPrefix()
	{
		return adminPrefix();
	}

}
