<?php

namespace App\Http\Controllers\api\v1;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\TokenRepository;
use App\Http\Controllers\api\v1\BaseController;

class PassportAuthController extends BaseController
{
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
        ]);

        $validated['password'] = Hash::make($request->password);

        $user = User::create($validated);

        $data['name'] = $user->name;
        $data['access_token'] = $user->createToken('access_token')->accessToken;

        return $this->sendResponse($data, 'User register successfully.');
    }

    public function login(Request $request)
    {
        $loginCredential = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (!Auth::attempt($loginCredential)) {
            return $this->sendError('Invalid login credentials.');
        }

        $user = Auth::user();

        $data['name'] = $user->name;
        $data['access_token'] = $user->createToken('access_token')->accessToken;

        return $this->sendResponse($data, 'User login successfully.');
    }

    public function logout(Request $request)
    {
        $token = $request->user()->token();
        $token->revoke();
        $token->delete();

        // $accessToken = auth()->user()->token();
        // $token = $request->user()->tokens->find($accessToken);
        // $token->revoke();

        // $tokenRepository = app(TokenRepository::class);
        // $tokenRepository->revokeAccessToken($token);

        return $this->sendResponse($token, 'Successfully logout');
    }
}