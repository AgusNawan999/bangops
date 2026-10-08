<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\LoginLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function store(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            // Catat Log ke Database
            LoginLogger::record(Auth::user(), $request, 'manual');

            return redirect()->intended('/dashboard');
        }

        throw ValidationException::withMessages([
            'email' => 'Kredensial yang Anda masukkan tidak cocok dengan data kami.',
        ]);
    }
}