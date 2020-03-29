<?php 

namespace Pingu\Entity\Entities;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Pingu\Core\Traits\Models\HasMachineName;
use Pingu\Entity\Entities\Entity;
use Pingu\Entity\Entities\Policies\ViewModePolicy;
use Pingu\Entity\Entities\ViewModesMapping;

class ViewMode extends Entity
{
    use HasMachineName;
    
    public $timestamps = false;

    public $fillable = ['name', 'machineName'];

    /**
     * @inheritDoc
     */
    public function getRouteKeyName()
    {
        return 'machineName';
    }

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
    public function mapping(): HasMany
    {
        return $this->hasMany(ViewModesMapping::class, 'view_mode_id');
    }
}