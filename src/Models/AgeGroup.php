<?php

namespace VermontDevelopment\CdbSync\Models;

use Illuminate\Database\Eloquent\Model;

class AgeGroup extends Model
{
    protected $table = 'cdb_age_groups';

    protected $fillable = [
        'id',
        'name',
        'age_from',
        'age_to',
        'description',
        'is_active',
    ];
}
