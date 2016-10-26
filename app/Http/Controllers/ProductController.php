<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Repositories\ProductRepository;

class ProductController extends Controller
{
    private $product;

    public function __construct(ProductRepository $product) {
        $this->product = $product;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAll()
    {
        try {
            $aRecord = $this->product->getAll(10);
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
            $aRecord = $this->product->store($request->all());
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
            $aRecord = $this->product->find($id);
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
            $aRecord = $this->product->update($request->all(), $id);
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
            $this->product->delete($id);
            return response()->api([], [], 200);
        } catch (\Exception $e) {
            return response()->api([], [], $e->getCode(), ['dev' => $e->getMessage()]);
        }
    }
}
