<?php

namespace Pingu\Entity\Contracts;

interface HasActionsContract
{
	public function actions(): Actions;
}