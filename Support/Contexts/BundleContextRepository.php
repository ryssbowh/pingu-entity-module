<?php

namespace Pingu\Entity\Support\Contexts;

use Pingu\Core\Support\Contexts\ObjectContextRepository;
use Pingu\Entity\Http\Contexts\CreateBundleFieldContext;
use Pingu\Entity\Http\Contexts\DeleteBundleFieldContext;
use Pingu\Entity\Http\Contexts\EditBundleFieldContext;
use Pingu\Entity\Http\Contexts\IndexBundleFieldsContext;
use Pingu\Entity\Http\Contexts\StoreBundleFieldContext;
use Pingu\Entity\Http\Contexts\UpdateBundleFieldContext;

class BundleContextRepository extends ObjectContextRepository
{
    public function __construct(array $contexts)
    {
        $this->add(IndexBundleFieldsContext::class);
        $this->add(EditBundleFieldContext::class);
        $this->add(CreateBundleFieldContext::class);
        $this->add(StoreBundleFieldContext::class);
        $this->add(UpdateBundleFieldContext::class);
        $this->add(DeleteBundleFieldContext::class);
        parent::__construct($contexts);
    }
}