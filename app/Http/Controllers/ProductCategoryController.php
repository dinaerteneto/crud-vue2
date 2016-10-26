<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Repositories\ProductCategoryRepository;

class ProductCategoryController extends Controller
{
    private $category;

    public function __construct(ProductCategoryRepository $category) {
        $this->category = $category;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAll()
    {
        try {
            $aRecord = $this->category->getAll(10);
            return response()->api(['data' => $aRecord], [], 200);
        } catch(\Exception $e) {
            return response()->api([], [], $e->getCode(), ['dev' => $e->getMessage()]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $aRecord = $this->category->store($request->all());
            return response()->api(['data' => $aRecord], [], 200);
        } catch (\Exception $e) {
            return response()->api([], [], $e->getCode(), ['dev' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $aRecord = $this->category->find($id);
            return response()->api(['data' => $aRecord], [], 200);
        } catch(\Exception $e) {
            return response()->api([], [], $e->getCode(), ['dev' => $e->getMessage()]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $aRecord = $this->category->update($request->all(), $id);
            return response()->api(['data' => $aRecord], [], 200);
        } catch (\Exception $e) {
            return response()->api([], [], $e->getCode(), ['dev' => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $this->category->delete($id);
            return response()->api([], [], 200);
        } catch (\Exception $e) {
            return response()->api([], [], $e->getCode(), ['dev' => $e->getMessage()]);
        }
    }

    public function getData() {
        try {
            return response()->json($this->category->getAll(0));
        } catch (\Exception $e) {
            return response()->api([], [], $e->getCode(), ['dev' => $e->getMessage()]);
        }
    }
}
