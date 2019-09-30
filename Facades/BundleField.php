<?php
namespace Pingu\Entity\Facades;

use Illuminate\Support\Facades\Facade;

class BundleField extends Facade {

	protected static function getFacadeAccessor() {

		return 'core.entity.field';

	}

}