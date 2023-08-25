<?php

namespace VermontDevelopment\CdbSync\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Diagram extends Model
{
    protected $table = 'cdb_diagrams';

    protected $fillable = [
        'id',
        'name',
        'code',
        'image',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function getImageUrlAttribute()
    {
        return config('app.url') . '/storage/' . $this->image;
    }

    public function orderGroup()
    {
        return $this->hasMany(OrderGroup::class);
    }
}
