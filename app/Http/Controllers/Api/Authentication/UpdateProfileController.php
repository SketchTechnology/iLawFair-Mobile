<?php

namespace App\Http\Controllers\Api\Authentication;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator; // Use for custom validation if needed


class UpdateProfileController extends Controller
{

    public function  __construct (){
        $this->middleware('auth:sanctum');
    }


    public function update(Request $request) // Consider using UpdateUserInformationRequest
    {
        $user = Auth::guard('sanctum')->user(); // Retrieve authenticated user

        // Custom validation if needed (optional)
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone_number' => 'required|regex:/^([+]?\d{1,2}[-\s]?){0,2}\(?\d{3}\)?[-\s]?\d{3}[-\s]?\d{4}$/' ,
            'email' => 'required|email|unique:users,email,' . $user->id
        ]);
        if ($validator->fails()) {
            return ApiResponse::sendResponse(400, 'Validation failed', $validator->errors());
        }

        // Update user information (consider using fillable or guarded attributes)
        $user->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone_number' => $request->phone_number,
            'email' => $request->email,
            'name' => $request->first_name . " " . $request->last_name

         ]);

        $data['name'] = $user->first_name . " " . $user->last_name;
        $data['email'] = $user->email;
        $data['first_name'] = $user->first_name;
        $data['last_name'] = $user->last_name;
        $data['phone_number'] = $user->phone_number;

        // Return success response
        return ApiResponse::sendResponse(200, 'User information updated successfully', $data);
    }
}
