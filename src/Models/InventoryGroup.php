<?php

namespace VermontDevelopment\CdbSync\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class InventoryGroup extends Model
{
    use HasFactory;

    protected $casts = [
        'is_active' => 'boolean'
    ];

    protected $fillable = [
        'id',
        'name',
        'description',
        'eso_id',
        'is_active',
    ];

    protected $table = 'cdb_inventory_groups';

    public function orderGroup(): HasMany
    {
        return $this->hasMany(OrderGroup::class);
    }
}
