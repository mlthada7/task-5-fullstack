<?php

namespace App\Http\Controllers\api\v1;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PassportAuthController extends Controller
{
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $validated['password'] = Hash::make($request->password);

        $user = User::create($validated);

        $accessToken = $user->createToken('access_token')->accessToken;

        return response([
            'user' => $user,
            'access_token' => $accessToken
        ], 200);
    }

    public function login(Request $request)
    {
        $loginCredential = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (!Auth::attempt($loginCredential)) {
            return response(['message' => 'Invalid login credentials']);
        }

        $user = Auth::user();
        $accessToken = $user->createToken('access_token')->accessToken;

        return response([
            'access_token' => $accessToken
        ]);
    }
}