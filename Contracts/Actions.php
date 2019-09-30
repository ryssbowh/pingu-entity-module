<?php

namespace Pingu\Entity\Contracts;

abstract class Actions
{
	public function __construct($object)
	{
		$this->object = $object;
	}

	public function get(): array
	{
		$actions = $this->actions();
		foreach($actions as $name => $action){
			if(method_exists($this, $name.'Access') and !$this->{$name.'Access'}()){
				unset($actions[$name]);
			}
		}
		return $actions;
	}

	abstract public function actions(): array;
}