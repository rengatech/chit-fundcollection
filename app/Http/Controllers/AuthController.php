<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'login_identifier' => 'required',
            'password' => 'required',
        ]);

        $field = filter_var($credentials['login_identifier'], FILTER_VALIDATE_EMAIL) ? 'email' : 'mobile';

        if (Auth::attempt([$field => $credentials['login_identifier'], 'password' => $credentials['password'], 'is_active' => 1])) {
            $request->session()->regenerate();

            return redirect()->intended('/member');
        }

        return back()->withErrors([
            'login_identifier' => 'The provided credentials do not match our records or account is inactive.',
        ])->withInput();
    }

    public function register(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'name' => 'nullable|string|max:255',
            'mobile' => 'nullable|string|size:10|unique:users',
        ]);

        $name = $request->name ?? explode('@', $request->email)[0];

        $user = User::create([
            'name' => $name,
            'mobile' => $request->mobile,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'member',
            'is_active' => true,
        ]);

        Auth::login($user);

        return redirect('/member');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
