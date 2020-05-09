<?php

namespace Pingu\Entity\Support;

use Illuminate\Support\Str;
use Pingu\Core\Entities\BaseModel;
use Pingu\Entity\Contracts\EntityContract;
use Pingu\Entity\Facades\Entity as EntityFacade;
use Pingu\Entity\Support\Forms\BaseEntityForms;
use Pingu\Entity\Traits\DefaultEntity;
use Pingu\Forms\Contracts\FormRepositoryContract;

abstract class Entity extends BaseModel implements EntityContract
{
    use DefaultEntity;

    public $adminListFields = [];

    /**
     * Boots entity
     */
    public static function boot()
    {
        parent::boot();

        static::registered(function($entity) {
            EntityFacade::registerEntity($entity);
        });
    }

    /**
     * Forms class for this entity
     * 
     * @return EntityFormRepositoryContract
     */
    public static function forms(): FormRepositoryContract
    {
        return new BaseEntityForms;
    }

    /**
     * Identifier for this entity, for internal use
     * 
     * @return string
     */
    public function identifier(): string
    {
        return 'entity-'.class_machine_name($this);
    }

    /**
     * @inheritDoc
     */
    public function viewIdentifier(): string
    {
        return \Str::kebab($this->identifier());
    }
    
    /**
     * @inheritDoc
     */
    public function getViewKey(): string
    {
        return $this->getKey();
    }
}