<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Manager;

class RegisterAdminController extends Controller
{
    public function showAdminRegister()
    {
        return view('admin.register');
    }

    // public function checkLogin(Request $request)
    // {
    //     // $code=config('code.code_check');
    //     $id=env('ID_KEY');
    //     $pass=env('PASS_KEY');
    //     if($request->id==$id && $request->password==$pass){
    //         return redirect()->back()->with('success', 'Check login success');            
    //     };

    //     return redirect('/welcome')->with('error', 'Faillllllllllll.....');
    // }

    public function createAdmin(Request $request)
    {
        $code=config('code.code_check');
        if($request->key!=$code){
            return redirect()->back()->with('error', 'Faillllllllllll.....');
        };

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

        return redirect()->back()->with('success', 'Admin has been added');
    }
}
