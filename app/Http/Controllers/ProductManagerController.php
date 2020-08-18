<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use SebastianBergmann\Environment\Console;
use Redirect;
use DataTables;

use Intervention\Image\Facades\Image;

class ProductManagerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:manager');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::all();

        return view('admin/product_manager', [
            'products' => $products,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin/create_product');
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
            'icon_pro' => ['max:2048', 'image', 'mimes:jpeg,png,jpg,gif,svg'],
            'price_license' => ['required', 'between:0,999999.99', 'numeric'],
        ]);

        $product = new Product();

        if ($file = $request->hasFile('icon_pro')) {
            $file = $request->file('icon_pro');
            $fileName = $file->getClientOriginalName();
            $destinationPath = public_path() . '/icon_pro/';
            $file->move($destinationPath, $fileName);
            $product->icon_pro = '/icon_pro/' . $fileName;
        }

        $product->name_pro = $request->name_pro;
        $product->description_pro = $request->description_pro;
        $product->price_license = $request->price_license;
        $product->save();

        return redirect()->route('product_manager.index')->with('success', 'Product store in database successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::findOrFail($id);
        return response()->json($product);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('admin/edit_product', [
            'product' => $product,
        ]);
        // return response()->json($product);
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
            'icon_pro' => ['max:2048', 'image', 'mimes:jpeg,png,jpg,gif,svg'],
            'price_license' => ['required', 'between:0,999999.99', 'numeric'],
        ]);

        $product = Product::find($id);
        if ($file = $request->hasFile('icon_pro')) {
            $file = $request->file('icon_pro');
            $fileName = $file->getClientOriginalName();
            $destinationPath = public_path() . '/icon_pro/';
            $file->move($destinationPath, $fileName);
            $product->icon_pro = '/icon_pro/' . $fileName;
        }

        $product->name_pro = $request->name_pro;
        $product->description_pro = $request->description_pro;
        $product->price_license = $request->price_license;
        $product->save();

        return redirect()->route('product_manager.index')->with('success', 'Product update in database successfully');
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
        return redirect()->back()
            ->with('success', 'Product deleted successfully');
    }
}
