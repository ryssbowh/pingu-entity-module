<?php

namespace Pingu\Entity\Support;

use Pingu\Entity\Contracts\Actions;

class BaseEntityBundleActions extends Actions
{
	public function actions(): array
	{
		return [
			'edit' => [
				'label' => 'Edit',
				'url' => $this->object->uris()->make('edit', $this->object, adminPrefix())
			],
			'indexFields' => [
				'label' => 'Manage fields',
				'url' => $this->object->bundleUris()->make('indexFields', $this->object, adminPrefix())
			],
			'delete' => [
				'label' => 'Delete',
				'url' => $this->object->uris()->make('confirmDelete', $this->object, adminPrefix())
			]
		];
	}
}