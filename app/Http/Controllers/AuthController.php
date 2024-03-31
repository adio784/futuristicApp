<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use App\Mail\VerifyEmail;
use App\Models\PasswordReset;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Password;
use App\Notifications\PasswordResetNotification;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
// use Laravolt\Avatar\Avatar as Avatar;
use Laravolt\Avatar\Facade as Avatar;

class AuthController extends Controller
{
    //verify email method
    public function verifyEmail(Request $request)
    {
        try {

            $request->validate([
                'token' => ['required']
            ]);

            $checkToken = PasswordReset::where('email', Auth::user()->email)->where('token', $request->token);

            if ( $checkToken->get()->isEmpty() ) {

                return response()->json([
                    'success'       => false,
                    'statusCode'    => 400,
                    'message'       => 'Invalid PIN'
                ]);

            } else {

                PasswordReset::where('email', Auth::user()->email)->where('token', $request->token)->delete();

                $User = User::find(Auth::user()->id);
                // $User = User::whereId(Auth::user()->id)->first();
                $User->email_verified_at = Carbon::now()->getTimestamp();
                $User->save();

                return response()->json([
                    'success'       => true,
                    'statusCode'    => 200,
                    'message'       => 'Email Verified ...'
                ]);
            }

        } catch (Exception $e) {

            return response()->json([
                'success'       => false,
                'statusCode'    => 400,
                'err'           => 'Error is here' . Auth::user()->id,
                'message'       => $e,
            ]);
        }
    }

    //reset Method
    public function reset_password(Request $request)
    {
        $request->validate([
            'email_address'     => 'required|email',
            'password'          => 'required|string|min:8|confirmed',
            'token'             => 'required|string',
        ]);

        $token = $request->token;
        $passwordReset = PasswordReset::where('token', Hash::make($token))->first();
        $User = User::where('email', $passwordReset->email)->first();

        if (!$passwordReset || Carbon::parse($passwordReset->created_at)->addMinutes(60)->isPast()) {
            return response()->json([
                'success'       => false,
                'statusCode'    => 400,
                'message'       => 'Token not found or expired !!!'
            ]);
        }

        $User->update([
            'password' => Hash::make($request->password)
        ]);

        $passwordReset->delete();

        return response()->json([
            'success'       => true,
            'statusCode'    => 200,
            'message'       => 'You Password Has Been Successfully Reset !!!'
        ]);
    }

    // resend verification pin
    public function resendPIN(Request $request)
    {
        try {

            $request->validate([
                'email' => ['required', 'string', 'email', 'max:255']
            ]);

            $chkEmail = DB::table('password_resets')->where('email', $request->email);

            if ($chkEmail->exists()) {
                $chkEmail->delete();
            }

            $token = random_int(100000, 999999);
            $passwordReset = DB::table('password_resets')
                ->insert([
                    'email'         => $request->email,
                    'token'         => $token,
                    'created_at'    => Carbon::now()
                ]);

            if ($passwordReset) {

                Mail::to($request->email)->send(new VerifyEmail($token));

                return response()->json([
                    'success'       => true,
                    'statusCode'    => 200,
                    'message'       => 'A new verification mail has been sent !!!',
                ]);
            }
        } catch (Exception $e) {

            return response()->json([
                'success'       => false,
                'statusCode'    => 400,
                'message'       => $e,
            ]);
        }
    }




    public function user(Request $request)
    {
        return $request->user();
    }


    private function generateProfileImage($initial, $userId)
    {

        // Generate a unique filename for the profile image
        $filename = $userId . '_' . time() . '.png';

        // Create a blank image
        // $image = imagecreate(100, 100);
        $image = imagecreate(100, 100);

        // Set background color
        $backgroundColor = imagecolorallocate($image, 255, 255, 255);

        // Set text color
        $textColor = imagecolorallocate($image, 0, 0, 0);

        // Add text (user's initial letter) to the image
        imagettftext($image, 40, 0, 20, 60, $textColor, public_path('fonts/arial.ttf'), $initial);

        // Save the image to the profiles directory
        imagepng($image, public_path('profiles/' . $filename));

        // Destroy the image resource
        imagedestroy($image);

        return 'profiles/' . $filename;
    }

    public function serviceworker()
    {
        return view('service-worker');
    }
}
