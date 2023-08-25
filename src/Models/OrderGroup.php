<?php

namespace VermontDevelopment\CdbSync\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class OrderGroup extends Model
{
    use HasFactory;

    protected $table = 'cdb_order_groups';

    protected $casts = [
        'is_active' => 'boolean'
    ];

    protected $fillable = [
        'id',
        'name',
        'name_sk_hu',
        'description',
        'eso_id',
        'diagram_id',
        'inventory_group_id',
        'is_active'
    ];

    public function diagram(): BelongsTo
    {
        return $this->belongsTo(Diagram::class);
    }

    public function inventoryGroup(): BelongsTo
    {
        return $this->belongsTo(InventoryGroup::class);
    }
}
