<?php 

namespace Pingu\Entity\Entities;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Pingu\Core\Entities\BaseModel;
use Pingu\Entity\Entities\ViewMode;

class ViewModesEntities extends BaseModel
{
    public $timestamps = false;

    public $fillable = ['entity'];

    public $with = ['view_mode'];

    /**
     * View mode relationship
     * 
     * @return BelongsTo
     */
    public function view_mode()
    {
        return $this->belongsTo(ViewMode::class);
    }
}