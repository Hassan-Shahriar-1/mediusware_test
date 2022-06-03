<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{

    public $timestemps=true;

    /* public function price(){
        return $this->belongsToMany(ProductVariantPrice::class,'product_variant_one','product_variant_two','product_variant_three','id');
    } */
}
