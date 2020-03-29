<?php 

namespace Pingu\Entity\Entities;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Pingu\Core\Entities\BaseModel;
use Pingu\Entity\Entities\ViewMode;

class ViewModesMapping extends BaseModel
{
    public $timestamps = false;

    public $fillable = ['entity'];

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