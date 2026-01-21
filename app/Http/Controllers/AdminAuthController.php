<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AdminAuthController extends Controller
{
    // 🔐 Admin login pagina
    public function showLogin()
    {
        return view('admin.login');
    }

    // 🔐 Admin login verwerken
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt([
            'email' => $credentials['email'],
            'password' => $credentials['password'],
            'is_admin' => 1,
        ])) {
            $request->session()->regenerate();
            return redirect()->route('reviews.index');
        }

        return back()->withErrors([
            'email' => 'Geen admin rechten.',
        ]);
    }

    // 📝 Admin registratie pagina
    public function showRegister()
    {
        return view('admin.register');
    }

    // 📝 Admin registratie verwerken
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'is_admin' => 1,
        ]);

        return redirect()->route('admin.login')
            ->with('success', 'Admin account aangemaakt!');
    }

    // 🚪 Admin logout
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}
