<?php

namespace App\Http\Controllers\Api\Authentication;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class ChangePasswordController extends Controller
{

    public function  __construct (){
        $this->middleware('auth:sanctum');
    }

    
    public function changePassword(Request $request)
    {
        $user = Auth::guard('sanctum')->user(); // Retrieve authenticated user

        $this->validate($request, [
            'current_password' => 'required|string|current_password', // Validate current password
            'password' => 'required|string|min:8|confirmed', // Enforce password complexity and confirmation
        ]);

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        // Success response
        return response()->json([
            'message' => 'Password changed successfully',
        ], 200);
    }
}
