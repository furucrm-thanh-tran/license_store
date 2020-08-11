<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Manager;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ManagerController extends BaseController
{
    /**
     * Login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        // Validate form data
        $validator = Validator::make($request->all(), [
            'user_name' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:8'],
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
        
        if (Auth::guard('manager')->attempt(['user_name' => $request->user_name, 'password' => $request->password])) {

            if (Auth::guard('manager')->user()->role == 1) {
                $user = Auth::guard('manager')->user();
                $success['token'] = $user->createToken('Token Admin', ['admin'])->accessToken;
                $success['user_name'] =  $user->user_name;

                return $this->sendResponse($success, 'Admin login successfully.');
            } else {
                $user = Auth::guard('manager')->user();
                $success['token'] = $user->createToken('Token Seller', ['seller'])->accessToken;
                $success['user_name'] =  $user->user_name;

                return $this->sendResponse($success, 'Seller login successfully.');
            }
        } else {
            return $this->sendError('Unauthorised.', ['error' => 'Unauthorised']);
        }
    }
}
