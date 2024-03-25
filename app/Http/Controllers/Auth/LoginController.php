<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    //
    //Login Methods
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $User = User::where('email', $request->username)->orWhere('username', $request->username)->first();

        if (!empty($User)) {

            if (!Auth::attempt($request->only('username', 'password')) && !Auth::attempt($request->only('email', 'password'))) {
                throw ValidationException::withMessages([
                    'Email /Phone' => ['The provided credentials are incorrect.'],
                ]);
            }

            $user = Auth::user();
            $accessToken = $User->createToken('auth_token')->plainTextToken; //$User->createToken('Personal Access Token')->plainTextToken; //$User->createToken('api-token')->plainTextToken;

            User::whereId($user->id)
                ->update([
                    'online'    => true,
                ]);

            return response()->json([
                'success'       => true,
                'statusCode'    => 200,
                'message'       => 'Account Successfully Created !!!',
                'access_token'  => $accessToken,
                'token_type'    => 'Bearer',
                'User'          =>  $User,
            ]);
        } else {

            return response()->json([
                'success'       => false,
                'statusCode'    => 400,
                'message'       => 'No Account Found for this User !!!'
            ]);
        }
    }

    // Logout method
    public function logout(Request $request): JsonResponse
    {

        $user = Auth::user();
        $request->user()->tokens()->delete();

        User::whereId($user->id)
            ->update([
                'isOnline'    => false,
            ]);

        return new JsonResponse(
            [
                'success' => true,
                'message' =>'Logged Out Successfully'
            ],
            200
        );
    }
}