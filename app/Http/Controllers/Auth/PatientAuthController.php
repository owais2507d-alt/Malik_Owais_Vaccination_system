<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PatientAuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.patient-login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::guard('web')->attempt($credentials + ['role' => 'patient'])) {
            return redirect()->route('patient.dashboard');
        }

        return back()->with('error', 'Invalid credentials');
    }

    public function showRegister()
    {
        return view('auth.patient-register');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'phone' => 'nullable|string',
            'address' => 'nullable|string',
            'location' => 'nullable|string',
        ]);

        $data['password'] = Hash::make($data['password']);
        $data['role'] = 'patient';

        $user = User::create($data);
        Auth::guard('web')->login($user);

        return redirect()->route('patient.dashboard');
    }

    public function logout()
    {
        Auth::guard('web')->logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect('/');
    }
}
