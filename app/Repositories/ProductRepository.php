<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use App\Repositories\ProductRepositoryInterface;
use App\Models\Product;
use App\Models\ProductXProductCategory;
use Intervention\Image\ImageManagerStatic as Image;

class ProductRepository implements ProductRepositoryInterface
{

    public function getAll(int $iPerPage) {
        $aReturn = [];
        $aRecords = Product::paginate($iPerPage);
        if($aRecords) {
            $i = 0;
            foreach($aRecords as $oRecord) {
                $aReturn[$i] = $oRecord;
                $aReturn[$i]['categories'] = $oRecord->categories();
                $i++;
            }
        }
        return $aReturn;
    }

    public function find(int $id) {
        return Product::find($id);
    }

    public function store($aParam = []) {
        $aData = isset($aParam['Product']) ? $aParam['Product'] : null;
        $model = new Product();
        \DB::beginTransaction();
        try {
            if(!$model->validate($aData)) {
                throw new \Exception($model->errors(), 1000);
            }

            if(isset($aParam['Image'])) {
                $aData['image'] = $this->attachImage($aParam['Image']);
            }

            $model->fill($aData);
            $model->push();

            //add category in product
            if(isset($aParam['ProductCategory'])) {
                $this->addCategory($aParam['ProductCategory'], $model->id);
            }
            \DB::commit();

            return $model;
        } catch (\Illuminate\Database\QueryException $e) {
            \DB::rollback();
            throw new \Exception($e->getMessage(), $e->getCode());
        } catch(\Exception $e) {
            throw new \Exception($e->getMessage(), $e->getCode());
        }
    }

    public function update($aParam = [], $id) {
        $aData = isset($aParam['Product']) ? $aParam['Product'] : null;
        $model = Product::find($id);

        \DB::beginTransaction();
        try {
            if(!$model->validate($aData)) {
                throw new \Exception($model->errors(), 1000);
            }
            if(isset($aParam['Image'])) {
                $aData['image'] = $this->attachImage($aParam['Image']);
            }
            $model->fill($aData);
            $model->update();

            //add category in product
            if(isset($aParam['ProductCategory'])) {
                $this->addCategory($aParam['ProductCategory'], $model->id);
            }
            \DB::commit();

            return $model;
        } catch (\Illuminate\Database\QueryException $e) {
            \DB::rollback();
            throw new \Exception($e->getMessage(), $e->getCode());
        } catch(\Exception $e) {
            throw new \Exception($e->getMessage(), $e->getCode());
        }
    }

    public function delete($id) {
        return Product::destroy($id);
    }

    /**
     * add categories in product
     * @param array $aParam = catogories id to associate product
     * @return bool
     */
    public function addCategory($aParam = [], $id_product) {
        ProductXProductCategory::where('id_product', $id_product)->delete();
        foreach($aParam as $id_product_category) {
            //i know
            //sorry about that, but in the right way, it did not work
            $sql = "INSERT INTO product_x_product_category (id_product, id_product_category) VALUES ({$id_product},{$id_product_category}) ";
            \DB::statement($sql);
        }
        return true;
    }

    /**
     * remove a category of the product
     * @param int $id_product_category = id category
     */
    public function delCategory($id_product_category, $id_product) {
        $aParams = [
            'id_product' => $id_product,
            'id_product_category' => $id_product_category
        ];
        return ProductXProductCategory::where($aParams)->delete();
    }

    /**
     * attach image on product
     * @param $file
     * @return String
     */
    public function attachImage($file) {
        try {
            $imageName = time().".".$file->getClientOriginalName();
            $destination = public_path().'/img/product/';
            if(!is_dir($destination)) {
                mkdir($destination);
            }
            $file->move($destination, $imageName);

            $img = Image::make("{$destination}/{$imageName}")
                ->resize(80, null, function($constraint){
                    $constraint->aspectRatio();
                });
            $img->save("{$destination}/thumb-{$imageName}");

            return "img/product/thumb-{$imageName}";
        } catch(\Exception $e) {
            throw new \Exception($e->getMessage(), 1);
        }
    }
}
?>