<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\Models\Access;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cookie;

class AuthController extends Controller
{
    public function auth()
    {
        return Auth::user();
    }

    public function access()
    {
        $user = Auth::user();
        $access = Access::find($user->access_id);

        return response()->json([
            'access' => $access->name
        ], 200);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $items = $request->input('items');

        if (Auth::attempt($credentials)) {
            $auth = Auth::user();
            $access = Access::find($auth->access_id);

            if ($auth->is_bot) {
                $token = Auth::user()->createToken('auth-token', ['bot'])->plainTextToken;
            } else {
                $token = Auth::user()->createToken('auth-token', [$access->name])->plainTextToken;
            }


            if ($items && in_array('conect', $items)) {
                $cookie = cookie('jwt', $token);
                $permanent = true;
            } else {
                $cookie = cookie('jwt', $token, 60 * 24);
                $permanent = false;
            }

            return response()->json([
                'permanent' => $permanent,
                'token' => $token,
                'user' => Auth::user()
            ])->withCookie($cookie);
        }

        return response()->json([
            'error' => 'Credenciais inválidas'
        ], 401);
    }

    public function register(Request $request)
    {
        try {
            return User::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'is_bot' => $request->input('is_bot'),
                'password' => Hash::make($request->input('password')),
                'access_id' => 2,
                'sector_id' => $request->input('sector'),
            ]);
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function logout(Request $request)
    {
        $cookie = Cookie::forget('jwt');
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json([
            'message' => 'success'
        ], 200)->withCookie($cookie);
    }
}
