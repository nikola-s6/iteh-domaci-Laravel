<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Rules\HasNumbers;
use App\Rules\PasswordMatch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|unique:users',
            'email' => 'required|string|email|unique:users',
            'password_check' => 'required|string',
            'password' => ['required', 'string', new HasNumbers, new PasswordMatch],
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $user = User::create(['username' => $request->username, 'password' => Hash::make($request->password), 'email' => $request->email]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json(['registered_user' => $user, 'access_token' => $token, 'token_type' => 'Bearer']);
    }
}
