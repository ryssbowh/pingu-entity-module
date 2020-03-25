<?php 

namespace Pingu\Entity\Entities;

use Pingu\Core\Entities\BaseModel;

class ViewMode extends BaseModel
{
    public $timestamps = false;

    public $fillable = ['name'];
}