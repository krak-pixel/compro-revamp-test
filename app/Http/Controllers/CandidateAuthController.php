<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class CandidateAuthController extends Controller
{
    public function showLogin(): View
    {
        return view('career.auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email:rfc', 'max:255'],
            'password' => ['required', 'string'],
        ]);

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            return back()
                ->withInput($request->only('email'))
                ->withErrors(['email' => 'Email atau password yang Anda masukkan tidak sesuai.']);
        }

        $request->session()->regenerate();

        return redirect()->intended(route('career.index'));
    }

    public function showRegister(): View
    {
        return view('career.auth.register');
    }

    public function register(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['nullable', 'string', 'max:100'],
            'email' => ['required', 'email:rfc', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Password::min(6)],
        ]);

        User::create([
            'name' => $validated['name'] ?? null,
            'email' => $validated['email'],
            'password' => $validated['password'],
        ]);

        return redirect()
            ->route('login')
            ->with('status', 'Akun berhasil dibuat. Silakan masuk menggunakan akun Anda.');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('career.index');
    }
}
