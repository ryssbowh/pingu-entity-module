<?php 

namespace Pingu\Entity\Traits;

use Illuminate\Http\Request;
use Pingu\Entity\Contracts\BundleContract;
use Pingu\Entity\Entities\BundleField as BundleFieldModel;
use Pingu\Forms\Support\Form;

trait BundleField
{
	/**
	 * @inheritDoc
	 */
	public function field()
	{
		return $this->morphOne(BundleFieldModel::class, 'instance');
	}

	/**
	 * @inheritDoc
	 */
	public function storeValue($value)
	{
		return $value;
	}

	/**
	 * @inheritDoc
	 */
	public function retrieveValue($value)
	{
		return $value;
	}

    public static function create(array $genericAttributes, array $fieldAttributes, BundleContract $bundle)
    {
        $bundleField = new static;
        $bundleField->saveWithRelations($fieldAttributes);
        $generic = new BundleFieldModel($genericAttributes);
        $generic->bundle = $bundle->bundleName();
        $generic->instance()->associate($bundleField);
        $generic->save();
        return $bundleField;
    }

    public function bundle()
    {
    	return $this->field->bundle();
    }

}