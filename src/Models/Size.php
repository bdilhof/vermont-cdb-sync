<?php

namespace VermontDevelopment\CdbSync\Models;

use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\Model;

class Size extends Model
{
    use HasTimestamps;

    protected $table = 'cdb_sizes';

    protected $fillable = [
        'id',
        'eso_id',
        'code',
        'size_weight',
        'is_active',
    ];
}
