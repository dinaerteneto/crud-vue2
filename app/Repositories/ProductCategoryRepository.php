<?php

namespace App\Repositories;

use App\Repositories\ProductRepositoryInterface;
use App\Models\ProductCategory;

class ProductCategoryRepository implements ProductRepositoryInterface
{

    public function getAll(int $iPerPage = 0) {
        if($iPerPage <= 0) {
            return ProductCategory::all(['id', 'name as text']);
        }
        return ProductCategory::paginate($iPerPage);
    }

    public function find(int $id) {
    	return ProductCategory::find($id);
    }

    public function store($aParam = []) {
        $aData = isset($aParam['ProductCategory']) ? $aParam['ProductCategory'] : null;
        $model = new ProductCategory();

        \DB::beginTransaction();
        try {
            if(!$model->validate($aData)) {
                throw new \Exception($model->errors(), 1000);
            }
            $model->fill($aData);
            $model->push();

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
        $aData = isset($aParam['ProductCategory']) ? $aParam['ProductCategory'] : null;
        $model = ProductCategory::find($id);

        \DB::beginTransaction();
        try {
            if(!$model->validate($aData)) {
                throw new \Exception($model->errors(), 1000);
            }
            $model->fill($aData);
            $model->update();

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
        return ProductCategory::destroy($id);
    }
}
?>