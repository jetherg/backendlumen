<?php

namespace App\Http\Controllers;

use App\Models\User;
use Firebase\JWT\JWT;
use Firebase\JWT\ExpiredException;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->User = new User;
    }

    protected function jwt(User $user)
    {
        $payload = [
            'iss' => "lumen-jwt", // Issuer of the token
            'sub' => $user->id, // Subject of the token
            'iat' => time(), // Time when JWT was issued.
            'exp' => time() + 60 * 60 // Expiration time
        ];

        return JWT::encode($payload, env('JWT_SECRET'));
    }


    public function login(Request $request)
    {
        $this->validate($request, [
            'username'     => 'required|email',
            'password'  => 'required'
        ]);

        // Find the user by email
        $user = $this->User->where('username', $request->input('username'))->first();
        if (!$user) {
            return response()->json([
                'error' => 'User does not exist.'
            ], 400);
        }
        // Verify the password and generate the token
        if (Hash::check($request->input('password'), $user->password)) {
            return response()->json([
                'token' => $this->jwt($user),
                'user' => [
                    'username' => $user->username,
                    'name' => $user->name,
                ]
            ], 200);
        }
        // Bad Request response
        return response()->json([
            'error' => 'Username or password is wrong.'
        ], 400);
    }
}
