<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\VerifiesEmails;

class AuthApiController extends Controller
{
    use VerifiesEmails;

    public function register(Request $request) {

        $validation = Validator::make($request->all(), [
            'name' => 'required|max:55',
            'email' => 'email|required|unique:users',
            'password' => 'required|confirmed'
        ]);

        if($validation->fails()) {
            return response()->json([
                'isRegistered' => false,
                'errors' => $validation->errors()
            ]);

        } else {
            
            $request['password'] = Hash::make($request->password);

            $user = User::create($request->all());

            $accessToken = $user->createToken('userToken')->accessToken;

            $user->sendApiEmailVerificationNotification();

            return response()->json([
                'isRegistered' => true,
                'user' => $user,
                'access_token' => $accessToken
            ]);

        }

    }

    public function login(Request $request) {

        $validatedLoginData = Validator::make($request->all(), [
            'email' => 'email|required',
            'password' => 'required'
        ]);

        if($validatedLoginData->fails()) {
            return response()->json([
                'isLogged' => false,
                'errors' => $validatedLoginData->errors()
            ]);

        } else {

            if(!auth()->attempt($validatedLoginData->valid())) {
                return response()->json([
                    'isLogged' => false,
                    'errors' => 'Invalid Credentials'
                ]);

            } else {

                $accessToken = auth()->user()->createToken('userToken')->accessToken;

                return response()->json([
                    'isLogged' => true,
                    'user' => auth()->user(),
                    'access_token' => $accessToken
                ]);


            }

        }

    }

    public function sendPasswordResetNotification($token) {
        $this->notify(new \App\Notifications\MailResetPasswordNotification($token));
    }
}
