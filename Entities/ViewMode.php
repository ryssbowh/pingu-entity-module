<?php 

namespace Pingu\Entity\Entities;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Pingu\Core\Traits\Models\HasMachineName;
use Pingu\Entity\Entities\Entity;
use Pingu\Entity\Entities\Policies\ViewModePolicy;
use Pingu\Entity\Entities\ViewModesEntities;

class ViewMode extends Entity
{
    use HasMachineName;
    
    public $timestamps = false;

    public $fillable = ['name', 'machineName'];

    public $with = ['entities'];

    /**
     * @inheritDoc
     */
    public function getPolicy(): string
    {
        return ViewModePolicy::class;
    }

    /**
     * view mode entity mapping relationship
     * 
     * @return HasMany
     */
    public function entities(): HasMany
    {
        return $this->hasMany(ViewModesEntities::class, 'view_mode_id');
    }
}