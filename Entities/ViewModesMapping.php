<?php 

namespace Pingu\Entity\Entities;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Pingu\Core\Entities\BaseModel;
use Pingu\Entity\Entities\ViewMode;

class ViewModesMapping extends BaseModel
{
    public $timestamps = false;

    public $fillable = ['object'];

    /**
     * View mode relationship
     * 
     * @return BelongsTo
     */
    public function view_mode()
    {
        return $this->belongsTo(ViewMode::class);
    }

    /**
     * Resolve the associated object
     * 
     * @return Entity|BundleContract
     */
    public function getObject()
    {
        try {
            return \Bundle::get($this->object);
        } catch(EntityBundleException $e) {
            return \Entity::get($this->object);
        }
    }
}