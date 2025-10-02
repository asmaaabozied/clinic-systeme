<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VisitType extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function visits()
    {
        return $this->hasMany(Visit::class);
    }
}
