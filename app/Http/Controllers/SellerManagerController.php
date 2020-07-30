<?php

namespace App\Http\Controllers;

use App\Manager;
use Illuminate\Http\Request;
use SebastianBergmann\Environment\Console;
use Redirect, Response;
use DataTables;

class SellerManagerController extends Controller
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
        $sellermanagers = Manager::all()->where('role', 0);

        return view('admin/seller_manager', [
            'sellermanagers' => $sellermanagers,
        ]);

        // return redirect()->route('seller_manager.index', ['sellermanagers' => $sellermanagers]);

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

        $validatedData = $request->validate([
            'user_name' => ['required', 'string', 'max:255', 'unique:managers'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:managers'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'full_name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'regex:/(0)[0-9]{9}/', 'max:10']
        ]);

        Manager::create([
            'user_name' => $request->user_name,
            'password' => bcrypt($request->password),
            'full_name' => $request->full_name,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);    

        return redirect(route('seller_manager.index'))->with('success', 'Seller has been added');

        // $sellerId = $request->seller_id;
        // Manager::updateOrCreate(['id' => $sellerId], [
        //     'user_name' => $request->user_name,
        //     'password' => bcrypt($request->password),
        //     'full_name' => $request->full_name,
        //     'email' => $request->email,
        //     'phone' => $request->phone,
        // ]);
        // if(empty($request->seller_id))
		// 	$msg = 'Seller entry created successfully.';
		// else
		// 	$msg = 'Seller data is updated successfully';
		// return redirect()->route('seller_manager.index')->with('success',$msg);
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $sellermanager = Manager::findOrFail($id);
        // return response()->json(['sellermanager' => $sellermanager], 200);
        return response()->json($sellermanager);
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
        $validatedData = $request->validate([
            'email' => ['required'],            
            'full_name' => ['required'],
            'phone' => ['required']
        ]);

        $sellermanager = Manager::find($id);
        $sellermanager->full_name =  $request->full_name;
        $sellermanager->email = $request->email;
        $sellermanager->phone = $request->phone;
        $sellermanager->save();
        return redirect(route('seller_manager.index'))->with('success', 'Seller has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $sellermanager = Manager::findOrFail($id);
        $sellermanager->delete();
        return redirect()->route('seller_manager.index')
            ->with('success', 'Seller deleted successfully');
    }
}
