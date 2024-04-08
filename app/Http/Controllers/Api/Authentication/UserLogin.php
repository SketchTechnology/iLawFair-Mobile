<?php

namespace App\Http\Controllers\Api\Authentication;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth ;
use App\Helpers\ApiResponse ;
use App\Http\Requests\UserLoginRequest;


class UserLogin extends Controller
{
    public function login(UserLoginRequest $request)
    {


        $credentials =['email' => $request->email, 'password' => $request->password] ;

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            // $user->tokens()->delete();
            $data['token'] =  $user->createToken('employeeLogin',['employee'])->plainTextToken;
            $data['name'] =  $user->first_name . " " . $user->last_name;
            $data['email'] =  $user->email;
            $data['first_name'] =  $user->first_name;
            $data['last_name'] =  $user->last_name;
            $data['phone_number'] =  $user->phone_number;
            return ApiResponse::sendResponse(200, 'Login Successfully', $data);
        } else {
            return ApiResponse::sendResponse(401, 'Error with your credentials', null);
        }
    }
}
