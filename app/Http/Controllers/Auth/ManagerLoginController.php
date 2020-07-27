<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ManagerLoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest:manager')->except('logout');
    }

    public function showLoginForm()
    {
        return view('auth.manager-login');
    }

    public function username()
    {
        return 'user_name';
    }

    public function login(Request $request)
    {
        // Validate form data
        $this->validate($request, [
            'password' => 'required|min:8'
        ]);

        if(Auth::guard('manager')->attempt(['user_name' => $request->user_name, 'password' => $request->password], $request->remember))
        {
            if (Auth::guard('manager')->user()->role == 1) {
                return redirect()->route('admin.home');
            }else{
                return redirect()->intended(route('seller.dashboard'));
            }
        }else{
            return redirect()->route('login')
                ->with('error','User Name or Password Are Wrong.');
        }

        // if unsuccessful
        return redirect()->back()->withInput($request->only('user_name','remember'));
    }
}
