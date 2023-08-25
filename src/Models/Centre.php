<?php

namespace VermontDevelopment\CdbSync\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Centre extends Model
{
    use SoftDeletes;

    protected $table = 'cdb_centres';

    protected $fillable = [
        'id',
        'cdb_id',
        'code',
        'name',
        'street',
        'number',
        'zip',
        'city',
        'email',
        'country_id',
        'public_ip',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function getFullNameAttribute()
    {
        return "{$this->code} - {$this->name}";
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}
