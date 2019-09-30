<?php

namespace Pingu\Entity\Traits\Controllers\Bundles;

use Illuminate\Database\Eloquent\Collection;
use Pingu\Entity\Contracts\BundleContract;
use Pingu\Entity\Forms\BundleFieldsForm;

trait IndexesAdminBundleFields
{
    use IndexesBundleFields;

    /**
	 * @inheritDoc
	 */
	protected function onIndexFieldsSuccess(BundleContract $bundle, Collection $fields)
	{
		\ContextualLinks::addFromObject($bundle);
		return $this->getIndexFieldsView($bundle, $fields);
	}

	/**
	 * Get the view for a create request
	 * 
	 * @param  Collection $fields
	 * @param  BundleContract $bundle
	 * @return view
	 */
	protected function getIndexFieldsView(BundleContract $bundle, Collection $fields)
	{
        $url = ['url' => $bundle->bundleUris()->make('createField', [], adminPrefix())];
        $form = new BundleFieldsForm($url);

		$canCreate = $bundle->accessor()->createFields();
		$canEdit = $bundle->accessor()->editFields();

		$with = [
			'fields' => $fields,
            'bundle' => $bundle,
            'form' => $form,
			'canCreate' => $canCreate,
			'canEdit' => $canEdit,
		];
		$this->addVariablesToIndexFieldsView($with, $bundle, $fields);
		
		return view($this->getIndexFieldsViewName($bundle))->with($with);
	}

	/**
	 * View name for creating models
	 * 
	 * @return string
	 */
	protected function getIndexFieldsViewName(BundleContract $bundle)
	{
		return 'entity::indexFields';
	}

	/**
	 * Callback to add variables to the view
	 * 
	 * @param array &$with
	 */
	protected function addVariablesToIndexFieldsView(array &$with, BundleContract $bundle, Collection $fields){}
    

}
