<?php

namespace App\Http\Controllers;

use App\Helpers\NotificationHelper;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HospitalController extends Controller
{
    public function dashboard()
    {
        $pendingCount = Appointment::where('hospital_id', Auth::id())->where('status', 'pending')->count();
        $totalAppointments = Appointment::where('hospital_id', Auth::id())->count();
        $recentRequests = Appointment::where('hospital_id', Auth::id())
            ->with('patient')
            ->latest()
            ->take(5)
            ->get();

        return view('hospital.dashboard', compact('pendingCount', 'totalAppointments', 'recentRequests'));
    }

    public function requests()
    {
        $appointments = Appointment::where('hospital_id', Auth::id())
            ->with('patient')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('hospital.requests', compact('appointments'));
    }

    public function approve($id)
    {
        $appointment = Appointment::where('id', $id)->where('hospital_id', Auth::id())->firstOrFail();
        $appointment->update(['status' => 'approved']);

        NotificationHelper::create(
            $appointment->patient,
            'appointment_approved',
            'Appointment Approved',
            "Your {$appointment->type} appointment at {$appointment->hospital->hospital_name} on " . \Carbon\Carbon::parse($appointment->appointment_date)->format('M d, Y') . " has been approved.",
            route('patient.appointments')
        );

        return back()->with('success', 'Appointment approved');
    }

    public function reject($id)
    {
        $appointment = Appointment::where('id', $id)->where('hospital_id', Auth::id())->firstOrFail();
        $appointment->update(['status' => 'rejected']);

        NotificationHelper::create(
            $appointment->patient,
            'appointment_rejected',
            'Appointment Rejected',
            "Your {$appointment->type} appointment at {$appointment->hospital->hospital_name} on " . \Carbon\Carbon::parse($appointment->appointment_date)->format('M d, Y') . " has been rejected.",
            route('patient.appointments')
        );

        return back()->with('success', 'Appointment rejected');
    }

    public function updateTestResult(Request $request, $id)
    {
        $data = $request->validate([
            'test_result' => 'required|in:negative,positive',
        ]);

        $appointment = Appointment::where('id', $id)->where('hospital_id', Auth::id())->firstOrFail();
        $appointment->update($data);

        NotificationHelper::create(
            $appointment->patient,
            'test_result_updated',
            'Test Result Available',
            "Your COVID test result at {$appointment->hospital->hospital_name} is: " . strtoupper($data['test_result']) . ".",
            route('patient.appointments')
        );

        return back()->with('success', 'Test result updated');
    }

    public function updateVaccinationStatus(Request $request, $id)
    {
        $data = $request->validate([
            'vaccination_status' => 'required|in:vaccinated',
        ]);

        $appointment = Appointment::where('id', $id)->where('hospital_id', Auth::id())->firstOrFail();
        $appointment->update($data);

        NotificationHelper::create(
            $appointment->patient,
            'vaccination_completed',
            'Vaccination Completed',
            "You have been marked as vaccinated at {$appointment->hospital->hospital_name}. Stay protected!",
            route('patient.appointments')
        );

        return back()->with('success', 'Vaccination status updated');
    }
}
