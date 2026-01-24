<?php

namespace App\Http\Controllers;

<<<<<<< HEAD
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class HomeController extends Controller
{
    /**
     * Show the application dashboard or landing page.
     */
    public function index()
    {
return view('home');    }

    /**
     * Handle member login.
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required', 'string'],
            'password' => ['required'],
        ]);

        $loginField = $request->input('email');
        $password = $request->input('password');

        // Determine if login field is email or mobile
        $fieldType = filter_var($loginField, FILTER_VALIDATE_EMAIL) ? 'email' : 'mobile';

        $credentials = [
            $fieldType => $loginField,
            'password' => $password,
        ];

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            // Redirect based on role or to member panel by default for this route
            return redirect()->intended('/member');
        }

        throw ValidationException::withMessages([
            'email' => 'These credentials do not match our records.',
        ]);
    }

    /**
     * Handle member registration.
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'mobile' => ['required', 'string', 'max:15'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'password' => Hash::make($request->password),
            'role' => 'member', // standard member registration
            'is_active' => true,
        ]);

        Auth::login($user);

        return redirect('/member');
=======
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Define your plans
        $plans = [
            ['amount' => 300, 'months' => 10, 'total' => 3000],
            ['amount' => 400, 'months' => 10, 'total' => 4000],
            ['amount' => 500, 'months' => 10, 'total' => 5000],
            ['amount' => 750, 'months' => 12, 'total' => 9000],
            ['amount' => 1250, 'months' => 12, 'total' => 15000],
        ];

        // Pass $plans to the view
        return view('Home', compact('plans'));
>>>>>>> 5792fe652e9a780a31a58ba5a6704bea3c965332
    }
}
