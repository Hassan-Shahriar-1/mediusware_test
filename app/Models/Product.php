<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'title', 'sku', 'description'
    ];

    public function variant(){
        return $this->hasMany(ProductVariant::class,'product_id','id');
    }

}
