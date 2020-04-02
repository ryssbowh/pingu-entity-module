<?php 

namespace Pingu\Entity\Traits\Controllers;

use Pingu\Core\Traits\RendersAdminViews;
use Pingu\Entity\Support\Entity;

trait RendersEntityViews
{
    use RendersAdminViews;

    protected function renderEntityView($views, Entity $entity, string $action, array $data)
    {
        $identifier = $action.'-'.$entity->identifier();
        return $this->renderAdminView($views, $identifier, $data);
    }
}