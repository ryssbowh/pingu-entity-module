<?php

namespace Pingu\Entity\Contracts;

use Pingu\Core\Contracts\Models\HasRouteSlugContract;
use Pingu\Forms\Contracts\Models\FormableContract;

interface EntityContract extends FormableContract, HasActionsContract, HasAccessorContract, HasRouteSlugContract
{
	public static function machineName(): string;

	public static function machineNames(): string;

	public static function friendlyName(): string;

	public static function friendlyNames(): string;

	public function entityType(): string;

	public function forms(): EntityForms;

	public function uris(): Uris;

	public function routes(): Routes;

}