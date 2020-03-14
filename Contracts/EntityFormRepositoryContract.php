<?php

namespace Pingu\Entity\Contracts;

use Pingu\Forms\Contracts\FormRepositoryContract;
use Pingu\Forms\Support\Form;

interface EntityFormRepositoryContract extends FormRepositoryContract
{
    /**
     * Filter Form
     * 
     * @param array  $fields
     * @param array  $action
     * 
     * @return Form
     */
    public function filter(array $fields, array $action): Form;

    /**
     * Form to edit a revision
     * 
     * @param array  $args
     * 
     * @return Form
     */
    public function editRevision(array $args): Form;

}