<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;
use App\Notifications\PasswordResetNotification;
// use Laravolt\Avatar\Avatar as Avatar;
use Laravolt\Avatar\Facade as Avatar;

class AuthController extends Controller
{
    //

    //Login Methods
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $User = User::where('email_address', $request->username)->orWhere('phone_number', $request->username)->firstOrFail();

        if ($User->count('id') > 0) {

            if (!Auth::attempt($request->only('username', 'password')) && !Auth::attempt($request->only('phone_number', 'password'))) {
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


    public function register(Request $request)
    {
        $request->validate([
            'firstname'     => 'required|string|max:255',
            'lastname'      => 'required|string|max:255',
            'gender'        => 'required|string|max:12',
            'birth_day'     => 'required|integer|max:31',
            'birth_month'   => 'required|string|max:55',
            'birth_year'    => 'required|integer|max:2024',
            'password'      => ['required', 'confirmed', 'string', 'max:255', 'min:8', Rules\Password::defaults()],
        ]);
        $fullname = $request->lastname . ' ' . $request->firstname;
        $uniqId = strtolower($request->lastname) . '.' . strtolower($request->firstname) . '@futuristics.com';
        // Avatar::create($fullname)->toBase64(); Avatar::create($fullname)->save(storage_path(path: 'Avatars/avatar-' . $request->lastname[0] . $request->firstname . '.png'));
        $path = public_path('Avatars/avatar-');
        $ProfileImage = Avatar::create($fullname)->tosvg();

        try {
            $Create                 = new User();
            $Create->firstname      = $request->firstname;
            $Create->lastname       = $request->lastname;
            $Create->username       = $uniqId;
            $Create->email_address  = $uniqId;
            $Create->gender         = $request->gender;
            $Create->birth_day      = $request->birth_day;
            $Create->birth_month    = $request->birth_month;
            $Create->birth_year     = $request->birth_year;
            $Create->profile_image  = $ProfileImage;
            $Create->password       = Hash::make($request->password);
            $Create->save();

            $token = $Create->createToken('auth_token')->plainTextToken;

            $Create->save();

            return response()->json([
                'success'       => true,
                'statusCode'    => 200,
                'access_token'  => $token,
                'token_type'    => 'Bearer',
                'email'         => $uniqId,
                'message'       => 'Account Successfully Created !!!'
            ]);
        } catch (Exception $e) {

            return response()->json([
                'success'       => false,
                'statusCode'    => 400,
                'message'       => $e,
            ]);
        }
    }

    //send reset link Method
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'email_address'     => 'required|email',
        ]);

        $User = User::where('email_address', $request->email_address)->first();

        if (!empty($User)) {

            // return response()->json([
            //     'success'       => true,
            //     'statusCode'    => 200,
            //     'message'       => $User
            // ]);

            $token = Password::getRepository()->create($User->email);
            $User->notify(new PasswordResetNotification($token));

            return response()->json([
                'success'       => true,
                'statusCode'    => 200,
                'message'       => 'Reset Link Has Been Sent To The Email Address You Entered'
            ]);

        } else {

            return response()->json([
                'success'       => false,
                'statusCode'    => 400,
                'message'       => 'Email Address Not Found !!!'
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

        $User = User::where('email', $request->email_address)->firstOrFail();


        if (!empty($User)) {

            // $token = Password::getRepository()->create($User);
            $response = Password::reset($request->only('email', 'password', 'password_confirmation', 'token'), function ($user, $password) {
                $user->password = Hash::make($password);
                $user->save();
            });

            if ($response) {

                return response()->json([
                    'success'       => true,
                    'statusCode'    => 200,
                    'message'       => 'You Password Has Been Successfully Reset !!!'
                ]);
            } else {

                return response()->json([
                    'success'       => false,
                    'statusCode'    => 400,
                    'message'       => 'Password Reset Failed !!!'
                ]);
            }
        } else {

            return response()->json([
                'success'       => false,
                'statusCode'    => 400,
                'message'       => 'Email Address Not Found !!!'
            ]);
        }
    }

    //Logout Methods
    public function logout(Request $request)
    {

        $user = Auth::user();
        $request->user()->tokens()->delete();

        User::whereId($user->id)
            ->update([
                'online'    => false,
            ]);

        return response()->json([
            'success'       => true,
            'statusCode'    => '200',
            'message'       =>  'Account Successfully Logged Out !!!',
        ]);
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
}