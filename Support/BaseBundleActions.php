<?php

namespace Pingu\Entity\Support;

use Pingu\Entity\Contracts\Actions;

class BaseBundleActions extends Actions
{
	public function actions(): array
	{
		return [
			'indexFields' => [
				'label' => 'Manage fields',
				'url' => $this->object->bundleUris()->make('indexFields', $this->object, adminPrefix())
			]
		];
	}
}