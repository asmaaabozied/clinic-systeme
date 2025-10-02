<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChargeType extends Model
{
    protected $fillable = [
        'name',
    ];

    public function modules()
    {
        return $this->belongsToMany(Module::class, 'charge_type_module', 'charge_type_id', 'module_id');
    }
}
