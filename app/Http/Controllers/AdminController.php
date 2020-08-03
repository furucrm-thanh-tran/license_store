<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Manager;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:manager');
    }

    public function sellerManager()
    {
        return view('admin.seller_manager');
    }

    public function transactionManager()
    {
        return view('admin.transaction_manager');
    }

    public function productManager()
    {
        return view('admin.product_manager');
    }

    public function showProfile()
    {
        return view('admin.profile');
    }

    public function showAdminRegister()
    {
        return view('admin.register');
    }

    public function createAdmin(Request $request)
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
            'role' => '1',
        ]);

        return redirect(route('admin'))->with('success', 'Admin has been added');
    }
}
