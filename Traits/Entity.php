<?php 

namespace Pingu\Entity\Traits;

use Pingu\Entity\Entities\BundleField;
use Pingu\Entity\Entities\BundleFieldValue;
use Pingu\Entity\Events\EntityCreated;
use Pingu\Entity\Events\EntityUpdated;

trait Entity
{	
	public static function bootEntity()
	{
		static::created(function($entity){
			event(new EntityCreated($entity));
		});
		static::updated(function($entity){
			event(new EntityUpdated($entity));
		});
	}

	public function toArray()
	{
		$array = parent::toArray();
		foreach($this->bundle()->entityBundleFields() as $field){
			$array['field_'.$field->machineName] = $field->value($this);
		}
		return $array;
	}

	public function saveFieldValues(array $values)
	{
		$revision = $this->getLastRevision() + 1;
		foreach($this->bundle()->entityBundleFields() as $field){
			$value = $values[$field->machineName] ?? null;
        	$this->saveFieldValue($field, $value, $revision);
        }
	}

	protected function saveFieldValue(BundleField $field, $value, int $revision)
	{
		$fieldValue = new BundleFieldValue([
    		'value' => $field->instance->storeValue($value),
    		'revision_id' => $revision
    	]);
    	$fieldValue->field()->associate($field);
    	$fieldValue->entity()->associate($this);
    	$fieldValue->save();
	}

	public function getEntityBundleField(string $name)
	{
		return $this->bundle()->getEntityBundleField($name);
	}

	public function getLastRevision()
	{
		return $this->bundle()->entityBundleFields()[0]->getLastRevision($this);
	}

	public function fields()
	{
		return $this->morphMany(BundleFieldValue::class, 'entity')->keyBy('machineName');
	}

	public function buildBundleFieldClass(string $name)
	{
		return $this->bundle()->buildBundleFieldClass($name);
	}

	public function getBundleFieldValue(string $name)
	{
		return $this->getEntityBundleField($name)->value($this);
	}

    public function __get($key)
    {
    	if(substr($key, 0, 6) == 'field_'){
    		$field = $this->getEntityBundleField(strtolower(substr($key, 6)));
    		return $field->value($this);
    	}
        return $this->getAttribute($key);
    }
}