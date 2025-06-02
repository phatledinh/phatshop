<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
{
    // Validate input data including captcha
    $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        'phone' => [
            'required',
            'string',
            'max:15',
            'unique:users',
            'regex:/^0[1-9][0-9]{8,9}$/'
        ],
        'address' => ['required', 'string', 'max:255'],
        'password' => ['required', 'confirmed', Rules\Password::defaults()],
        'captcha' => ['required', 'captcha'],
    ], [
        'phone.regex' => 'Số điện thoại không đúng định dạng. Vui lòng nhập số bắt đầu bằng 0 và có 10-11 chữ số.',
        'phone.unique' => 'Số điện thoại đã được sử dụng.',
        'email.unique' => 'Email đã được sử dụng.',
        'captcha.required' => 'Vui lòng nhập mã xác nhận.',
        'captcha.captcha' => 'Mã xác nhận không đúng. Vui lòng thử lại.',
    ]);

    // Create the user
    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'phone' => $request->phone,
        'address' => $request->address,
        'password' => Hash::make($request->password),
        'image' => $request->image ?? 'photo_defaults.jpg',
        'role' => 'client',
    ]);

    event(new Registered($user));

    Auth::login($user);

    return redirect(RouteServiceProvider::HOME);
}
}