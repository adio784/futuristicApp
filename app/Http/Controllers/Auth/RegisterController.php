<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Exception;
use Carbon\Carbon;
use App\Models\User;
use App\Mail\VerifyEmail;
use App\Models\PasswordReset;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravolt\Avatar\Facade as Avatar;
use Illuminate\Validation\ValidationException;

// use Laravolt\Avatar\Avatar as Avatar;


class RegisterController extends Controller
{
    //

    // User registration
    public function register(Request $request)
    {
        try {

            $request->validate([
                'surname'       => 'required|string|max:255',
                'othername'     => 'required|string|max:255',
                'username'      => 'required|string|max:255',
                'email'         => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
                'gender'        => 'required|string|max:12',
                'birth_day'     => 'required|integer|max:31',
                'birth_month'   => 'required|string|max:55',
                'birth_year'    => 'required|integer|max:2024',
                'password'      => ['required', 'confirmed', 'string', 'max:255', 'min:8', Rules\Password::defaults()],
            ]);
            $fullname = $request->surname . ' ' . $request->othername;
            // Avatar::create($fullname)->toBase64(); Avatar::create($fullname)->save(storage_path(path: 'Avatars/avatar-' . $request->lastname[0] . $request->firstname . '.png'));
            $path = public_path('Avatars/avatar-');
            $ProfileImage = Avatar::create($fullname)->tosvg();

            $Create                 = new User();
            $Create->surname        = $request->surname;
            $Create->othername      = $request->othername;
            $Create->username       = $request->username;
            $Create->email          = $request->email;
            $Create->gender         = $request->gender;
            $Create->birthDay       = $request->birth_day;
            $Create->birthMonth     = $request->birth_month;
            $Create->birthYear      = $request->birth_year;
            $Create->profileImage   = $ProfileImage;
            $Create->password       = Hash::make($request->password);
            $Create->save();

            $token = $Create->createToken('auth_token')->plainTextToken;
            $Create->save();

            $verify = DB::table('password_resets')->where('email', $request->all()['email']);

            if ($verify->exists()) {
                $verify->delete();
            }

            $pin = rand(100000, 999999);
            PasswordReset::insert(
                [
                    'email' => $request->all()['email'],
                    'token' => $pin
                ]
            );
            Mail::to($request->email)->send(new VerifyEmail($pin));
            return response()->json([
                'success'       => true,
                'statusCode'    => 200,
                'access_token'  => $token,
                'token_type'    => 'Bearer',
                'message'       => 'Account Successfully Created, Please check your email for a 6-digit pin to verify your email.'
            ]);
        } catch (Exception $e) {

            return response()->json([
                'success'       => false,
                'statusCode'    => 400,
                'message'       => $e,
            ]);
        }
    }
}