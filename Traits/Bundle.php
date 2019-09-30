<?php

namespace Pingu\Entity\Traits;

use Illuminate\Database\Eloquent\Collection;
use Pingu\Entity\Contracts\Accessor;
use Pingu\Entity\Contracts\Routes;
use Pingu\Entity\Entities\BundleField;
use Pingu\Entity\Exceptions\BundleFieldException;
use Pingu\Entity\Support\BaseBundleAccessor;
use Pingu\Entity\Support\BaseBundleRoutes;
use Pingu\Forms\Support\Field;

trait Bundle
{
	public function accessor(): Accessor
	{
		return new BaseBundleAccessor($this);
	}

    public function bundleRoutes(): Routes
    {
        return new BaseBundleRoutes($this);
    }

	public function bundleFields(): Collection
	{
		return BundleField::where(['bundle' => $this->bundleName()])->orderBy('weight', 'asc')->get();
	}

	public function getEntityBundleField(string $name): BundleField
	{
		$field = $this->bundleFields()->where('machineName', $name)->first();
		if(!$field){
			throw BundleFieldException::notDefined($name, $this->bundleName());
		}
		return $field;
	}

	public function getFieldDefinition(string $name): array
	{
		return $this->getEntityBundleField($name)->bundleFieldDefinition();
	}

	public function getFieldValidationRule(string $name): array
	{
		return $this->getEntityBundleField($name)->bundleFieldValidationRule();
	}

	public function getFieldValidationMessages(string $name): array
	{
		return $this->getEntityBundleField($name)->bundleFieldValidationMessages();
	}

	public function buildBundleFieldClass(string $name): Field
	{
		return $this->getEntityBundleField($name)->buildBundleFieldClass();
	}

}