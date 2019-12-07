<?php

namespace Pingu\Entity\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Pingu\Entity\Events\EntityBundleDeleted;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        EntityBundleDeleted::class => [DeleteBundleFields::class]
    ];
}