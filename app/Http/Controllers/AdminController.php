<?php

namespace App\Http\Controllers;

use App\Helpers\NotificationHelper;
use App\Models\Appointment;
use App\Models\Hospital;
use App\Models\User;
use App\Models\Vaccine;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalPatients = User::where('role', 'patient')->count();
        $totalHospitals = Hospital::count();
        $pendingHospitals = Hospital::where('status', 'pending')->count();
        $totalAppointments = Appointment::count();
        $admin = Auth()->user();
        $unreadNotifications = $admin ? NotificationHelper::getRecent($admin, 5) : collect();
        $unreadCount = $admin ? NotificationHelper::unreadCount($admin) : 0;

        return view('admin.dashboard', compact(
            'totalPatients', 'totalHospitals', 'pendingHospitals', 'totalAppointments',
            'unreadNotifications', 'unreadCount'
        ));
    }

    public function hospitals()
    {
        $hospitals = Hospital::orderBy('created_at', 'desc')->get();

        return view('admin.hospitals', compact('hospitals'));
    }

    public function approveHospital($id)
    {
        $hospital = Hospital::findOrFail($id);
        $hospital->update(['status' => 'approved']);

        NotificationHelper::create(
            $hospital,
            'hospital_approved',
            'Registration Approved',
            "Your hospital {$hospital->hospital_name} has been approved! You can now log in and manage appointments.",
            route('hospital.login')
        );

        return back()->with('success', 'Hospital approved');
    }

    public function rejectHospital($id)
    {
        $hospital = Hospital::findOrFail($id);
        $hospital->update(['status' => 'rejected']);

        NotificationHelper::create(
            $hospital,
            'hospital_rejected',
            'Registration Rejected',
            "Your hospital {$hospital->hospital_name} registration has been rejected. Please contact support for more information.",
            null
        );

        return back()->with('success', 'Hospital rejected');
    }

    public function vaccines()
    {
        $vaccines = Vaccine::all();

        return view('admin.vaccines', compact('vaccines'));
    }

    public function storeVaccine(Request $request)
    {
        $data = $request->validate([
            'vaccine_name' => 'required|string|max:255',
        ]);

        Vaccine::create($data);

        $hospitals = Hospital::where('status', 'approved')->get();
        foreach ($hospitals as $hospital) {
            NotificationHelper::create(
                $hospital,
                'vaccine_added',
                'New Vaccine Available',
                "A new vaccine ({$data['vaccine_name']}) has been added to the system.",
                route('hospital.dashboard')
            );
        }

        return back()->with('success', 'Vaccine added');
    }

    public function toggleVaccine($id)
    {
        $vaccine = Vaccine::findOrFail($id);
        $newStatus = $vaccine->status === 'available' ? 'unavailable' : 'available';
        $vaccine->update(['status' => $newStatus]);

        return back()->with('success', 'Vaccine status toggled');
    }

    public function reports()
    {
        $appointments = Appointment::with(['patient', 'hospital'])->orderBy('created_at', 'desc')->get();

        return view('admin.reports', compact('appointments'));
    }

    public function export()
    {
        $appointments = Appointment::with(['patient', 'hospital'])
            ->orderBy('created_at', 'desc')
            ->get();

        $output = '<table border="1">';
        $output .= '<tr><th>ID</th><th>Patient</th><th>Hospital</th><th>Type</th><th>Date</th><th>Status</th><th>Test Result</th><th>Vaccination Status</th><th>Created</th></tr>';

        foreach ($appointments as $a) {
            $output .= '<tr>';
            $output .= '<td>'.$a->id.'</td>';
            $output .= '<td>'.($a->patient->name ?? 'N/A').'</td>';
            $output .= '<td>'.($a->hospital->hospital_name ?? 'N/A').'</td>';
            $output .= '<td>'.$a->type.'</td>';
            $output .= '<td>'.$a->appointment_date.'</td>';
            $output .= '<td>'.$a->status.'</td>';
            $output .= '<td>'.$a->test_result.'</td>';
            $output .= '<td>'.$a->vaccination_status.'</td>';
            $output .= '<td>'.$a->created_at.'</td>';
            $output .= '</tr>';
        }
        $output .= '</table>';

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename=covid_report.xls');

        echo $output;
        exit;
    }
}
