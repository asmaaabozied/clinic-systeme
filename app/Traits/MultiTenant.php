<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait MultiTenant
{
    public static function bootMultiTenant()
    {
        if(auth()->check()&& (auth()->user()->type != 'super admin' || auth()->user()->type != 'employee' )) {
            static::creating(function ($model) {
                $model->created_by = \Auth::user()->creatorId();
            });

                static::addGlobalScope('created_by', function (Builder $builder) {
                    return $builder->where('created_by', auth()->user()->creatorId());
                });

        }

    }
}
