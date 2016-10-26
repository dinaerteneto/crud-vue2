<?php

namespace App\Models;

use App\Models\AbstractModel;

class ProductCategory extends AbstractModel
{

    protected $table = 'product_category';

    protected $fillable = [
        'id',
        'name'
    ];

    protected $attributesLabel = [
        'name' => 'Categoria',
    ];

    protected $rules = [
        'name' => 'required|max:100',
    ];

    public function products() {
        return $this->belongsToMany('App\Models\Product', 'product_x_product_category', 'id_product', 'id_product_category');
    }

}
