<?php
declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

final class ApiAuthController extends Controller
{
    public function login(Request $request, Response $response)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = $request->user();

            return [
                'token' => $user->createToken('access_token')->plainTextToken
            ];
        }

        return $response->setStatusCode(403)->send();
    }

    public function logout(Request $request)
    {
        // $request->user()->currentAccessToken()->delete();
        $request->user()->tokens()->delete(); // logout from all devices
        Auth::logout();
    }

    public function user(Request $request)
    {
        return [
            'user' => $request->user()
        ];
    }
}
