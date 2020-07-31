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
        //
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
            'icon_pro' => ['required', 'max:2048'],
            'price_license' => ['required'],
        ]);

        $icon_file = $request->icon_pro;
        $icon = Image::make('./img/' . $icon_file);
        // dd($icon);
        Response::make($icon->encode('jpeg'));

        // $form_data = array(
        //     'name_pro' => $request->name_pro,
        //     'description_pro' => $request->description_pro,
        //     'icon_pro' => $icon,
        //     'price_license' => $request->price_license,
        // );

        // Product::create($form_data);

        $product = new Product();
        $product->name_pro = $request->name_pro;
        $product->description_pro = $request->description_pro;
        $product->icon_pro = $icon;
        $product->price_license = $request->price_license;
        $product->save();
        // dd($product);

        return redirect()->back()->with('success', 'Product store in database successfully');
    }

    function fetch_icon($icon_id)
    {
        $icon = Product::findOrFail($icon_id);

        $icon_file = Image::make($icon->icon_pro);

        $response = Response::make($icon_file->encode('jpeg'));
        return $response;
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::findOrFail($id, ['name_pro', 'description_pro', 'price_license']);
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
        // $product = Product::where('id', $id)->get(['id', 'name_pro', 'description_pro', 'price_license']);
        $product = Product::findOrFail($id, ['id', 'name_pro', 'description_pro', 'price_license']);
        return response()->json($product);
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
            // 'icon_pro' => ['required'],
            'price_license' => ['required'],
        ]);

        
        $icon_file = $request->icon_pro;
        // $icon = Image::make('./img/' . $icon_file);
        // Response::make($icon->encode('jpeg'));
        $product = Product::find($id);
        if ($icon_file != null) {
            $icon = Image::make('./img/' . $icon_file);
            Response::make($icon->encode('jpeg'));
            $product->name_pro = $request->name_pro;
            $product->description_pro = $request->description_pro;
            $product->icon_pro = $icon;
            $product->price_license = $request->price_license;
            $product->save();
        } else {
            $product->name_pro = $request->name_pro;
            $product->description_pro = $request->description_pro;
            $product->price_license = $request->price_license;
            $product->save();
        }

        // $icon_file = $request->icon_pro;
        // $icon = Image::make('./img/' . $icon_file);
        // // dd($icon);
        // Response::make($icon->encode('jpeg'));

        // $product = Product::find($id);
        // $product->name_pro = $request->name_pro;
        // $product->description_pro = $request->description_pro;
        // $product->icon_pro = $icon;
        // $product->price_license = $request->price_license;
        // $product->save();

        return redirect()->back()->with('success', 'Product update in database successfully');
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
