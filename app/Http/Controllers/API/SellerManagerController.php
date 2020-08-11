<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Manager;
use Validator;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Http\Resources\Manager as ManagerResource;

class SellerManagerController extends BaseController

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
        $sellermanagers = Manager::all()->where('role', 0);

        return $this->sendResponse(ManagerResource::collection($sellermanagers), 'Sellers retrieved successfully.');
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
            'password' => ['required', 'string', 'min:8'],
            'full_name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'regex:/(0)[0-9]{9}/', 'max:10']
        ]);

        $sellermanager = Manager::create([
            'user_name' => $request->user_name,
            'password' => bcrypt($request->password),
            'full_name' => $request->full_name,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);
        
        return $this->sendResponse(new ManagerResource($sellermanager), 'Seller created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $sellermanager = Manager::findOrFail($id);

        if (is_null($sellermanager)) {
            return $this->sendError('Seller not found.');
        }
        return $this->sendResponse(new ManagerResource($sellermanager), 'Sellers retrieved successfully.');
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
            'email' => ['required', 'string', 'email', 'max:255', 'unique:managers,email,' .$id],           
            'full_name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'regex:/(0)[0-9]{9}/', 'max:10']
        ]);

        $sellermanager = Manager::find($id);
        $sellermanager->full_name =  $request->full_name;
        $sellermanager->email = $request->email;
        $sellermanager->phone = $request->phone;
        $sellermanager->save();

        return $this->sendResponse(new ManagerResource($sellermanager), 'Sellers updated successfully.');
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

        return $this->sendResponse([], 'Seller deleted successfully.');
    }
}
