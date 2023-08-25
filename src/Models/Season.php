<?php

namespace VermontDevelopment\CdbSync\Models;

use Illuminate\Database\Eloquent\Model;

class Season extends Model
{
    protected $table = 'cdb_seasons';

    protected $fillable = [
        'id',
        'eso_id',
        'code',
        'name',
        'season_number',
    ];
}
