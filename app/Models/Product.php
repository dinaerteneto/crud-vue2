<?php

namespace App\Models;

use App\Models\AbstractModel;

class Product extends AbstractModel
{
    protected $table = 'product';

    protected $fillable = [
        'id',
        'image',
        'name',
        'description'
    ];

    protected $attributesLabel = [
        'image' => 'Imagem',
        'name' => 'Produto',
        'description' => 'Descrição'
    ];

    protected $rules = [
        'name' => 'required|max:255'
    ];

    public function categories() {
        $aReturn = [];
        $aRecords =ProductXProductCategory::select(['id_product', 'id_product_category', 'product_category.name'])
            ->where(['id_product' => $this->id])
            ->join('product', 'product_x_product_category.id_product', '=', 'product.id')
            ->join('product_category', 'product_x_product_category.id_product_category', '=', 'product_category.id')
            ->get()
            ->all();
        if($aRecords) {
            foreach($aRecords as $oRecord) {
                $aReturn[] = $oRecord->toArray();
            }
        }
        return $aReturn;
    }



   /**
     * relacionamento com ingredientes
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ingredientes() {
        return ProdutoXIngrediente::select(['ingr_codi', 'ingr_titu'])
            ->where(['prin_prod' => $this->prod_codi])
            ->join('ingrediente', 'prin_ingr', '=', 'ingr_codi')
            ->get()
            ->toArray();
    }

}
