<?php

namespace VermontDevelopment\CdbSync\Models;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    protected $table = 'cdb_currencies';

    protected $fillable = [
        'id',
        'html_symbol',
        'code',
        'name',
        'symbol',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
