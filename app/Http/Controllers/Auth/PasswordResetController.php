<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PasswordResetController extends Controller
{
    //

    // Password reset methos .......................
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email'     => ['required', 'string', 'email', 'max:255'],
            'password'  => ['required', 'string', 'min:6', 'max:255', 'confirmed']
        ]);

        $User = User::where('email', $request->email);
        $User->update([
                'password'  => Hash::make($request->password)
            ]);
        $token = $User->first()->createToken('auth_token')->plainTextToken;

        return new JsonResponse(
            [
                'status'    => true,
                'messaga'   => 'Password Successfully Reset',
                'token'     => $token
            ],
            200
        );

    }
}