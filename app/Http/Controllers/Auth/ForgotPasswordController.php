<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\ResetPassword;
use App\Models\PasswordReset;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class ForgotPasswordController extends Controller
{
    // Forgot password method
    public function forgotPassword(Request $request): JsonResponse
    {
        $request->validate([
            'email' => ['required', 'string', 'email', 'max:255']
        ]);

        $chkUser = User::where('email', $request->email)->first();

        if ($chkUser) {

            $chkUser2 = DB::table('password_resets')->where('email', $request->email);

            if ($chkUser2->exists()) {
                $chkUser2->delete();
            }

            $token = random_int(100000, 999999);

            $passwordReset = DB::table('password_resets')->insert([
                'email'     => $request->email,
                'token'     => $token,
                'created_at' => Carbon::now()
            ]);

            if ($passwordReset) {

                Mail::to($request->email)->send(new ResetPassword($token));
                return response()->json([
                    'success'       => true,
                    'statusCode'    => '200',
                    'message'       =>  'Please check your mail for the 6 digit pin to complete the process',
                ]);
            }
        } else {

            return response()->json([
                'success'       => false,
                'statusCode'    => '400',
                'message'       =>  'This email does not exist on our record !!!',
            ]);
        }
    }


    // Verify token for password
    public function verifyPin(Request $request)
    {
        $request->validate([
            'email' =>  ['required', 'string', 'email', 'max:255'],
            'token' =>  ['required']
        ]);

        $dbCheck = PasswordReset::where([
            'email' =>  $request->email,
            'token' =>  $request->token
        ]);

        if ($dbCheck->exists()) {

            $differenceTm = Carbon::now()->diffInSeconds($dbCheck->first()->created_at);
            if ($differenceTm > 3600) {
                return new JsonResponse([
                    'success'       => true,
                    'message'       =>  'Token Expired !!!',
                ], 400);
            }

            PasswordReset::where([
                'email' =>  $request->email,
                'token' =>  $request->token
            ])->delete();

            return new JsonResponse([
                'success'   => true,
                'message'   => 'Proceed to reset your password'
            ]);
        } else {

            return new JsonResponse([
                'success'   =>  true,
                'message'   =>  'Token Expired !!!',
            ], 400);

        }
    }
}
