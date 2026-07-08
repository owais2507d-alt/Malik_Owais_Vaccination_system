@extends('layouts.patient')

@section('title', 'My Appointments')
@section('page-title', 'My Appointments')
@section('page-subtitle', 'Track your bookings and results')

@section('content')
<div class="space-y-6">
    <div data-aos="fade-down" class="hidden md:flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-2xl md:text-3xl font-extrabold text-gray-900 tracking-tight">My Appointments</h1>
            <p class="text-gray-500 text-sm mt-1">Track your bookings and results</p>
        </div>
        <a href="{{ route('patient.search') }}" class="px-5 py-2.5 bg-gradient-to-r from-blue-500 to-indigo-600 text-white font-medium rounded-xl hover:from-blue-600 hover:to-indigo-700 transition shadow-sm hover:shadow-md flex items-center gap-2 text-sm whitespace-nowrap">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
            </svg>
            New Appointment
        </a>
    </div>

    @php
        $allAppointments = $appointments;
        $filterStatus = request('status');
        $filterType = request('type');
        if ($filterStatus) {
            $allAppointments = $allAppointments->where('status', $filterStatus);
        }
        if ($filterType) {
            $allAppointments = $allAppointments->where('type', $filterType);
        }
    @endphp

    <div data-aos="fade-up" data-aos-delay="100" class="bg-white rounded-2xl border border-gray-100 p-4 shadow-sm">
        <form method="GET" action="{{ route('patient.appointments') }}" class="flex flex-wrap gap-3 items-end">
            <div>
                <label class="block text-xs font-medium text-gray-500 mb-1">Status</label>
                <select name="status" class="px-3 py-2 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400 outline-none transition">
                    <option value="">All Status</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                </select>
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-500 mb-1">Type</label>
                <select name="type" class="px-3 py-2 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400 outline-none transition">
                    <option value="">All Types</option>
                    <option value="test" {{ request('type') == 'test' ? 'selected' : '' }}>Test</option>
                    <option value="vaccination" {{ request('type') == 'vaccination' ? 'selected' : '' }}>Vaccination</option>
                </select>
            </div>
            <button type="submit" class="px-4 py-2 bg-gradient-to-r from-blue-500 to-indigo-600 text-white text-sm font-medium rounded-xl hover:from-blue-600 hover:to-indigo-700 transition shadow-sm">
                Filter
            </button>
            @if(request('status') || request('type'))
                <a href="{{ route('patient.appointments') }}" class="px-4 py-2 bg-gray-100 text-gray-600 text-sm font-medium rounded-xl hover:bg-gray-200 transition">
                    Clear
                </a>
            @endif
        </form>
    </div>

    @if($appointments->count())
    <div data-aos="fade-up" data-aos-delay="150" class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gradient-to-r from-gray-50 to-gray-100/50 text-gray-600 text-xs uppercase tracking-wider">
                        <th class="text-left px-6 py-4 font-semibold">#</th>
                        <th class="text-left px-6 py-4 font-semibold">Hospital</th>
                        <th class="text-left px-6 py-4 font-semibold">Type</th>
                        <th class="text-left px-6 py-4 font-semibold">Date</th>
                        <th class="text-left px-6 py-4 font-semibold">Status</th>
                        <th class="text-left px-6 py-4 font-semibold">Test Result</th>
                        <th class="text-left px-6 py-4 font-semibold">Vaccination</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($appointments as $a)
                    <tr class="hover:bg-blue-50/30 transition group">
                        <td class="px-6 py-4 text-gray-500 font-mono text-xs">#{{ str_pad($a->id, 4, '0', STR_PAD_LEFT) }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-emerald-100 to-teal-100 flex items-center justify-center text-xs font-bold text-emerald-700 shrink-0">
                                    {{ strtoupper(substr($a->hospital->hospital_name ?? 'N', 0, 1)) }}
                                </div>
                                <span class="font-medium text-gray-900">{{ $a->hospital->hospital_name ?? 'N/A' }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium 
                                @if($a->type === 'test') bg-blue-50 text-blue-700
                                @else bg-purple-50 text-purple-700 @endif">
                                <span class="w-1.5 h-1.5 rounded-full 
                                    @if($a->type === 'test') bg-blue-500
                                    @else bg-purple-500 @endif">
                                </span>
                                {{ ucfirst($a->type) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-gray-600">{{ \Carbon\Carbon::parse($a->appointment_date)->format('M d, Y') }}</td>
                        <td class="px-6 py-4">
                            @php
                                $colors = ['approved' => 'bg-emerald-100 text-emerald-700', 'rejected' => 'bg-red-100 text-red-700', 'pending' => 'bg-amber-100 text-amber-700'];
                            @endphp
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $colors[$a->status] ?? 'bg-gray-100 text-gray-600' }}">
                                {{ ucfirst($a->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            @if($a->test_result === 'positive')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-700">Positive</span>
                            @elseif($a->test_result === 'negative')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-700">Negative</span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-500">Pending</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            @if($a->vaccination_status === 'vaccinated')
                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-700">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                    Vaccinated
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-500">Not Vaccinated</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @else
    <div data-aos="fade-up" data-aos-delay="150" class="bg-white rounded-2xl border border-gray-100 shadow-sm p-12 text-center">
        <div class="w-20 h-20 bg-gradient-to-br from-gray-100 to-gray-200 rounded-2xl flex items-center justify-center mx-auto mb-4">
            <svg class="w-10 h-10 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
        </div>
        <h3 class="text-xl font-bold text-gray-900 mb-1">No appointments</h3>
        <p class="text-gray-500 text-sm mb-6 max-w-sm mx-auto">You haven't booked any appointments yet. Search for hospitals to get started.</p>
        <a href="{{ route('patient.search') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-blue-500 to-indigo-600 text-white font-semibold rounded-xl hover:from-blue-600 hover:to-indigo-700 transition shadow-lg shadow-blue-200/50 hover:shadow-blue-300/70 hover:-translate-y-0.5 text-sm">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            Search Hospitals
        </a>
    </div>
    @endif

    <a href="{{ route('patient.dashboard') }}" class="inline-flex items-center gap-1.5 text-sm text-gray-500 hover:text-gray-700 transition bg-white px-4 py-2 rounded-xl border border-gray-200 hover:border-gray-300 shadow-sm hover:shadow">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M7 16l-4-4m0 0l4-4m-4 4h18"/>
        </svg>
        Back to Dashboard
    </a>
</div>
@endsection