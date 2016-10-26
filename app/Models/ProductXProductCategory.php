<?php

namespace App\Models;

use App\Models\AbstractModel;

class ProductXProductCategory extends AbstractModel {

	protected $table = 'product_x_product_category';

	//protected $primaryKey = ['id_product', 'id_product_category'];

    protected $fillable = [
        'id_product',
        'id_product_category'
    ];

    protected $rules = [
        'id_product' => 'required|integer',
        'id_product_category' => 'required|integer'
    ];

}