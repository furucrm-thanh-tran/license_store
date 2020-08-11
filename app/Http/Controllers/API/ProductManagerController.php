<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Validator;
use App\Http\Resources\ProductManager as ProductResource;
use App\Product;

class ProductManagerController extends BaseController
{
    public function __construct()
    {
        $this->middleware('auth:apimanager');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::all();

        return $this->sendResponse(ProductResource::collection($products), 'Products retrieved successfully.');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name_pro'  => ['required'],
            'description_pro' => ['required'],
            'price_license' => ['required'],
        ]);
        $product = new Product();
        $product->name_pro = $request->name_pro;
        $product->description_pro = $request->description_pro;
        $product->price_license = $request->price_license;
        $product->save();

        return $this->sendResponse(new ProductResource($product), 'Product created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::findOrFail($id, ['id', 'name_pro', 'description_pro', 'price_license']);
        return $this->sendResponse(new ProductResource($product), 'Product retrieved successfully.');
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
        $request->validate([
            'name_pro'  => ['required'],
            'description_pro' => ['required'],
            'price_license' => ['required'],
        ]);


        $product = Product::findOrFail($id);
        $product->name_pro = $request->name_pro;
        $product->description_pro = $request->description_pro;
        $product->price_license = $request->price_license;
        $product->save();

        return $this->sendResponse(new ProductResource($product), 'Product updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return $this->sendResponse([], 'Product deleted successfully.');
    }
}
