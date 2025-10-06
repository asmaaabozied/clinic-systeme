<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseReturn extends Model
{
    protected $guarded = [];


    public function branch()
    {
        return $this->belongsTo('App\Models\Branch', 'branch_id', 'id');
    }

    public function product()
    {
        return $this->belongsTo('App\Models\ProductService', 'product_id', 'id');
    }
}
