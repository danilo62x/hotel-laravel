<?php

namespace App\Http\Controllers;

use App\Support\MockUsers;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function showLogin(): View
    {
        return view('pages.public.login', ['pageTitle' => 'Entrar']);
    }

    public function login(Request $request, MockUsers $users): RedirectResponse
    {
        $data = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // Mock auth: any non-empty email/password logs in.
        $user = $users->authenticate($data['email'], $data['password']);
        if (!$user) {
            return back()->withErrors(['global' => 'Credenciais inválidas. Tente novamente.'])->withInput();
        }

        $request->session()->put('user', $user);

        // Redirect: explicit ?redirect, else the dashboard.
        $redirect = $request->input('redirect') ?: route('dashboard');

        return redirect($redirect);
    }

    public function showRegister(): View
    {
        return view('pages.public.register', ['pageTitle' => 'Criar conta']);
    }

    public function register(Request $request, MockUsers $users): RedirectResponse
    {
        $data = $request->validate([
            'name' => 'required|string|min:2',
            'email' => 'required|email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $request->session()->put('user', $users->register($data['name'], $data['email']));

        return redirect()->route('dashboard');
    }

    public function showForgotPassword(): View
    {
        return view('pages.public.forgot-password', ['pageTitle' => 'Recuperar senha']);
    }

    public function logout(Request $request): RedirectResponse
    {
        $request->session()->forget('user');

        return redirect()->route('login');
    }
}
