<?php

namespace Pingu\Entity\Support\Uris;

use Pingu\Core\Support\Uris;
use Pingu\Entity\Support\Entity;

class BaseEntityUris extends Uris
{
    protected $entity;

    /**
     * Constructor. Will add the base entity uris
     * 
     * @param Entity $entity
     */
    public function __construct(Entity $entity)
    {
        $this->entity = $entity;
        $entityUris = \Uris::get(Entity::class);
        $this->addMany($entityUris->all());
        $this->replaceMany($this->uris());
    }

    /**
     * Add an uri to this class. Will replace entity tokens within the uri
     * 
     * @param string $action
     * @param string $uri
     */
    public function add(string $action, string $uri)
    {
        $uri = $this->replaceEntitySlugs($uri);
        parent::add($action, $uri);
    }

    /**
     * Replace an uri in this class. Will replace entity tokens within the uri
     * 
     * @param string $action
     * @param string $uri
     */
    public function replace(string $action, string $uri)
    {
        $uri = $this->replaceEntitySlugs($uri);
        parent::replace($action, $uri);
    }

    /**
     * Replaces entity tokens by the entity slug in an uri
     * tokens can be '@entity' or '@entities'
     * 
     * @param  string $uri
     * @return string
     */
    protected function replaceEntitySlugs(string $uri)
    {
        $uri = str_replace('@entity', $this->entity::routeSlug(), $uri);
        return str_replace('@entities', $this->entity::routeSlugs(), $uri);
    }

    /**
     * @inheritDoc
     * 
     * @return array
     */
    protected function uris(): array
    {
        return [];
    }
}