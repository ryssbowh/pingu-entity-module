<?php

namespace Pingu\Entity\Traits;

use Pingu\Core\Exceptions\UriException;

trait AccessUris
{
	/**
	 * Gets an uri by calling the associate static method on this object.
	 * The method name must start with the action wanted, followed by 'Uri'
	 * example 'deleteUri'
	 * 
	 * @param  string $action
	 * @param  ?string $prefix
	 * @return string
	 * @throws UriException
	 */
	public function get(string $action, ?string $prefix = null)
	{	
		$prefix = $prefix ? trim($prefix, '/').'/' : '';
		if(method_exists($this, $action)){
			return '/'.$prefix.trim($this->$action(), '/');
		}
		throw UriException::undefined($action, $this);
	}

	/**
	 * Transform an uri, replacing all slugs by values in replacements array
	 * 
	 * @param  string  $action
	 * @param  mixed $replacements
	 * @param  ?string $prefix
	 * @return string
	 */
	public function make(string $action, $replacements = [], ?string $prefix = null)
	{
		$replacements = (is_array($replacements) ? $replacements : [$replacements]);
		$uri = $this->get($action, $prefix);
		return replaceUriSlugs($uri, $replacements);
	}
}