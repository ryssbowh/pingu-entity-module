<?php 

namespace Pingu\Entity\Support;

use Pingu\Entity\Contracts\BundleContract;
use Pingu\Entity\Contracts\EntityContract;
use Pingu\Entity\Contracts\EntityForms as EntityFormsContract;
use Pingu\Forms\Support\Form;

class BundledEntityForms extends EntityFormsContract
{
	public function createForm(BundleContract $bundle): Form
	{
		return new CreateBundledEntityForm($this->entity, $bundle);
	}

	public function editForm(): Form
	{
		return new EditEntityForm($this->entity);
	}

	public function deleteForm(): Form
	{
		return new DeleteEntityForm($this->entity);
	}
}