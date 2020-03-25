<?php 

namespace Pingu\Entity\Contracts;

interface RenderableContract
{
    public function render(string $viewMode);
}