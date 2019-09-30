<?php

namespace Pingu\Entity\Entities;

use Entity as EntityFacade;
use Pingu\Core\Entities\BaseModel;
use Pingu\Core\Traits\Models\HasRouteSlug;
use Pingu\Entity\Contracts\Accessor;
use Pingu\Entity\Contracts\Actions;
use Pingu\Entity\Contracts\EntityContract;
use Pingu\Entity\Contracts\EntityForms;
use Pingu\Entity\Contracts\Routes;
use Pingu\Entity\Contracts\Uris;
use Pingu\Entity\Support\BaseEntityAccessor;
use Pingu\Entity\Support\BaseEntityActions;
use Pingu\Entity\Support\BaseEntityForms;
use Pingu\Entity\Support\BaseEntityRoutes;
use Pingu\Entity\Support\BaseEntityUris;

abstract class BaseEntity extends BaseModel implements EntityContract
{
    use HasRouteSlug;

    public $adminListFields = [];

	public function entityType(): string
	{
		return $this::machineName();
	}

	public function accessor(): Accessor
    {
        return new BaseEntityAccessor($this);
    }

    public function forms(): EntityForms
    {
        return new BaseEntityForms($this);
    }

    public function uris(): Uris
    {
        return new BaseEntityUris($this);
    }

    public function actions(): Actions
    {
        return new BaseEntityActions($this);
    }

    public function routes(): Routes
    {
        return new BaseEntityRoutes($this);
    }
}