<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\NotificationHelper;
use App\Http\Controllers\Controller;
use App\Models\Hospital;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class HospitalAuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.hospital-login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $hospital = Hospital::where('email', $credentials['email'])->first();

        if (! $hospital || ! Hash::check($credentials['password'], $hospital->password)) {
            return back()->with('error', 'Invalid credentials');
        }

        if ($hospital->status !== 'approved') {
            return back()->with('error', 'Your account is pending approval by admin');
        }

        Auth::guard('hospital')->login($hospital);

        return redirect()->route('hospital.dashboard');
    }

    public function showRegister()
    {
        return view('auth.hospital-register');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'hospital_name' => 'required|string|max:255',
            'email' => 'required|email|unique:hospitals',
            'password' => 'required|min:6',
            'address' => 'nullable|string',
            'location' => 'nullable|string',
        ]);

        $data['password'] = Hash::make($data['password']);

        $hospital = Hospital::create($data);

        $admins = User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            NotificationHelper::create(
                $admin,
                'hospital_registered',
                'New Hospital Registration',
                "{$hospital->hospital_name} has registered and is awaiting approval.",
                route('admin.hospitals')
            );
        }

        return redirect()->route('hospital.login')->with('success', 'Registration submitted. Wait for admin approval.');
    }

    public function logout()
    {
        Auth::guard('hospital')->logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect('/');
    }
}
