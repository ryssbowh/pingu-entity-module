<?php

namespace Pingu\Entity\Listeners;


class DeleteBundleFields
{

    /**
     * Creates field values for all content already defined for that content type
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        foreach($event->bundle->entityBundleFields() as $field){
            $field->instance->delete();
            $field->delete();
        }
    }
}
