<?php 

namespace Pingu\Entity\Entities;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Pingu\Core\Traits\Models\HasMachineName;
use Pingu\Entity\Entities\ViewModesMapping;
use Pingu\Entity\Http\Contexts\EditViewModeContext;
use Pingu\Entity\Http\Contexts\IndexViewModeContext;
use Pingu\Entity\Http\Contexts\PatchViewModeContext;
use Pingu\Entity\Http\Contexts\UpdateViewModeContext;
use Pingu\Entity\Support\Entity;

class ViewMode extends Entity
{
    use HasMachineName;
    
    public $timestamps = false;

    public $fillable = ['name', 'machineName'];

    public static $routeContexts = [
        EditViewModeContext::class, 
        UpdateViewModeContext::class,
        IndexViewModeContext::class,
        PatchViewModeContext::class
    ];

    /**
     * @inheritDoc
     */
    public function getRouteKeyName()
    {
        return 'machineName';
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

    /**
     * @inheritDoc
     */
    public function resolveRouteBinding($value)
    {
        return \ViewMode::getByName($value);
    }
}