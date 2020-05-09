<?php

namespace Pingu\Entity\Contracts;

use Pingu\Forms\Contracts\FormRepositoryContract;
use Pingu\Forms\Support\Form;

interface EntityFormRepositoryContract extends FormRepositoryContract
{
    /**
     * Form to edit a revision
     * 
     * @param array  $args
     * 
     * @return Form
     */
    public function editRevision(array $args): Form;

}