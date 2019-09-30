<?php

namespace Pingu\Entity\Support;

use Pingu\Entity\Contracts\Uris;
use Pingu\Entity\Entities\BundleField;
use Pingu\Entity\Traits\Uris\BundleUris;
use Pingu\Entity\Traits\Uris\EntityUris;

class BaseEntityBundleUris extends Uris
{
    use EntityUris, BundleUris;
}