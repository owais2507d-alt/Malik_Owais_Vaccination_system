<?php

namespace App\Http\Controllers;

use App\Helpers\NotificationHelper;
use App\Models\Appointment;
use App\Models\Hospital;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PatientController extends Controller
{
    public function dashboard()
    {
        $appointments = Appointment::where('patient_id', Auth::id())->with('hospital')->latest()->take(5)->get();

        return view('patient.dashboard', compact('appointments'));
    }

    public function search()
    {
        $hospitals = collect();

        return view('patient.search', compact('hospitals'));
    }

    public function searchHospitals(Request $request)
    {
        $query = $request->input('query');
        $hospitals = Hospital::where('status', 'approved')
            ->where(function ($q) use ($query) {
                $q->where('hospital_name', 'like', "%{$query}%")
                    ->orWhere('location', 'like', "%{$query}%");
            })
            ->get();

        return view('patient.search', compact('hospitals'));
    }

    public function bookForm($hospitalId)
    {
        $hospital = Hospital::findOrFail($hospitalId);

        return view('patient.book', compact('hospital'));
    }

    public function book(Request $request)
    {
        $data = $request->validate([
            'hospital_id' => 'required|exists:hospitals,id',
            'type' => 'required|in:test,vaccination',
            'appointment_date' => 'required|date|after:today',
        ]);

        $data['patient_id'] = Auth::id();

        $appointment = Appointment::create($data);

        $hospital = Hospital::find($data['hospital_id']);
        $patient = Auth::user();

        NotificationHelper::create(
            $hospital,
            'appointment_booked',
            'New Appointment Booking',
            "{$patient->name} booked a {$appointment->type} appointment for " . \Carbon\Carbon::parse($appointment->appointment_date)->format('M d, Y') . ".",
            route('hospital.requests')
        );

        return redirect()->route('patient.appointments')->with('success', 'Appointment booked successfully');
    }

    public function appointments()
    {
        $appointments = Appointment::where('patient_id', Auth::id())
            ->with('hospital')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('patient.my-appointments', compact('appointments'));
    }

    public function profile()
    {
        $patient = Auth::user();

        return view('patient.profile', compact('patient'));
    }

    public function updateProfile(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string',
            'address' => 'nullable|string',
            'location' => 'nullable|string',
        ]);

        User::where('id', Auth::id())->update($data);

        return back()->with('success', 'Profile updated successfully');
    }

    public function deleteAccount()
    {
        $user = Auth::user();
        Auth::guard('web')->logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        $user->delete();

        return redirect('/')->with('success', 'Account deleted');
    }
}
