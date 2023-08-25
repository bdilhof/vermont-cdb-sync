<?php

namespace VermontDevelopment\CdbSync\Models;

use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    protected $table = 'cdb_colors';

    protected $fillable = [
        'id',
        'eso_id',
        'name',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
