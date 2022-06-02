<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ProductVariant;

class Product extends Model
{
    protected $fillable = [
        'title', 'sku', 'description'
    ];

    public function varient(){
        return $this->hasMany(ProductVariant::class,'product_id','id');
    }

}
