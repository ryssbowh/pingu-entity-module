<?php 

namespace Pingu\Entity\Support;

use Pingu\Entity\Contracts\EntityContract;
use Pingu\Entity\Contracts\EntityForms;
use Pingu\Entity\Forms\CreateEntityForm;
use Pingu\Entity\Forms\DeleteEntityForm;
use Pingu\Entity\Forms\EditEntityForm;
use Pingu\Forms\Support\Form;

class BaseEntityForms extends EntityForms
{
	public function create(array $action): Form
	{
		return new CreateEntityForm($this->entity, $action);
	}

	public function edit(array $action): Form
	{
		return new EditEntityForm($this->entity, $action);
	}

	public function delete(array $action): Form
	{
		return new DeleteEntityForm($this->entity, $action);
	}
}