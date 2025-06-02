<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Http\Controllers\CartController;
use Illuminate\Support\Facades\Log;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        try {
            $request->authenticate();
            $request->session()->regenerate();
            (new CartController)->mergeCartAfterLogin();

            // Kiểm tra vai trò và điều hướng
            $user = Auth::user();
            if ($user->role === 'admin') {
                return redirect()->intended(route('admin'));
            }
            return redirect()->intended(route('home'));
        } catch (\Exception $e) {
            Log::error('Login error: ' . $e->getMessage());
            return redirect()->route('login')->withErrors(['error' => 'Đăng nhập thất bại, vui lòng thử lại.']);
        }
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}