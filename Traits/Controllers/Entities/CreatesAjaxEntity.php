<?php

namespace Pingu\Entity\Traits\Controllers\Entities;

use Pingu\Entity\Entities\BaseEntity;
use Pingu\Forms\Support\Form;

trait CreatesAjaxEntity
{
	use CreatesEntity;

	/**
	 * @inheritDoc
	 */
	protected function onCreateFormCreated(Form $form, BaseEntity $entity)
	{	
		return ['form' => $form->renderAsString()];
	}

	/**
	 * @inheritDoc
	 */
	protected function afterCreateFormCreated(Form $form, BaseEntity $entity)
	{
		$form->addViewSuggestion('forms.modal')
			->addClass('js-ajax-form')
			->option('title', 'Add a '.$entity::friendlyName());
	}

	/**
	 * @inheritDoc
	 */
	protected function getStoreUriPrefix()
	{
		return ajaxPrefix();
	}
}