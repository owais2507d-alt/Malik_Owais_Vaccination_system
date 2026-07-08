@extends('layouts.patient')

@section('title', 'Patient Dashboard')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Welcome back, {{ Auth::user()->name }}!')

@section('content')
<div class="space-y-6">
    <div data-aos="fade-down">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white text-xl font-bold shadow-lg shadow-blue-200/50">
                    {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                </div>
                <div>
                    <h1 class="text-2xl md:text-3xl font-extrabold text-gray-900 tracking-tight">Welcome back, {{ Auth::user()->name }}</h1>
                    <p class="text-gray-500 text-sm flex items-center gap-2 mt-0.5 flex-wrap">
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-700">
                            <span class="w-1.5 h-1.5 bg-blue-500 rounded-full"></span>
                            Patient Portal
                        </span>
                        <span class="text-gray-300">•</span>
                        <span>{{ now()->format('l, M d, Y') }}</span>
                    </p>
                </div>
            </div>
            <a href="{{ route('patient.search') }}" class="px-5 py-2.5 bg-gradient-to-r from-blue-500 to-indigo-600 text-white font-medium rounded-xl hover:from-blue-600 hover:to-indigo-700 transition shadow-sm hover:shadow-md flex items-center gap-2 text-sm whitespace-nowrap">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                </svg>
                New Appointment
            </a>
        </div>
    </div>

    <div data-aos="fade-up" data-aos-delay="100" class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        @php
            $total = $appointments->count();
            $approved = $appointments->where('status', 'approved')->count();
            $pending = $appointments->where('status', 'pending')->count();
            $rejected = $appointments->where('status', 'rejected')->count();
            $vaccinated = Auth::user()->vaccination_status ?? false;
            $positiveTests = $appointments->where('test_result', 'positive')->count();
            $negativeTests = $appointments->where('test_result', 'negative')->count();
        @endphp

        <div class="bg-white rounded-2xl border border-gray-100 p-5 shadow-sm card-hover">
            <div class="flex items-center justify-between mb-2">
                <p class="text-xs text-gray-400 uppercase tracking-wider font-semibold">Total</p>
                <svg class="w-5 h-5 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
            </div>
            <p class="text-3xl font-extrabold text-gray-900">{{ $total }}</p>
            <div class="mt-2 h-1.5 w-full bg-gray-100 rounded-full overflow-hidden">
                <div class="h-full w-full bg-blue-500 rounded-full progress-bar"></div>
            </div>
        </div>
        <div class="bg-white rounded-2xl border border-gray-100 p-5 shadow-sm card-hover">
            <div class="flex items-center justify-between mb-2">
                <p class="text-xs text-gray-400 uppercase tracking-wider font-semibold">Approved</p>
                <svg class="w-5 h-5 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <p class="text-3xl font-extrabold text-emerald-600">{{ $approved }}</p>
            <div class="mt-2 h-1.5 w-full bg-gray-100 rounded-full overflow-hidden">
                <div class="h-full w-{{ $total > 0 ? round(($approved/$total)*100) : 0 }}% bg-emerald-500 rounded-full progress-bar"></div>
            </div>
        </div>
        <div class="bg-white rounded-2xl border border-gray-100 p-5 shadow-sm card-hover">
            <div class="flex items-center justify-between mb-2">
                <p class="text-xs text-gray-400 uppercase tracking-wider font-semibold">Pending</p>
                <svg class="w-5 h-5 text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <p class="text-3xl font-extrabold text-amber-600">{{ $pending }}</p>
            <div class="mt-2 h-1.5 w-full bg-gray-100 rounded-full overflow-hidden">
                <div class="h-full w-{{ $total > 0 ? round(($pending/$total)*100) : 0 }}% bg-amber-500 rounded-full progress-bar"></div>
            </div>
        </div>
        <div class="bg-white rounded-2xl border border-gray-100 p-5 shadow-sm card-hover">
            <div class="flex items-center justify-between mb-2">
                <p class="text-xs text-gray-400 uppercase tracking-wider font-semibold">Rejected</p>
                <svg class="w-5 h-5 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <p class="text-3xl font-extrabold text-red-600">{{ $rejected }}</p>
            <div class="mt-2 h-1.5 w-full bg-gray-100 rounded-full overflow-hidden">
                <div class="h-full w-{{ $total > 0 ? round(($rejected/$total)*100) : 0 }}% bg-red-500 rounded-full progress-bar"></div>
            </div>
        </div>
    </div>

    <div data-aos="fade-up" data-aos-delay="150" class="grid grid-cols-1 md:grid-cols-2 gap-5">
        <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm card-hover">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-gray-400 uppercase tracking-wider font-semibold">Vaccination Status</p>
                    @if($vaccinated)
                        <p class="text-lg font-bold text-emerald-600 mt-1">Vaccinated</p>
                        <p class="text-xs text-gray-400">Protected against COVID-19</p>
                    @else
                        <p class="text-lg font-bold text-amber-600 mt-1">Not Vaccinated</p>
                        <p class="text-xs text-gray-400">Book your vaccination today</p>
                    @endif
                </div>
                <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-{{ $vaccinated ? 'emerald' : 'amber' }}-100 to-{{ $vaccinated ? 'teal' : 'orange' }}-100 flex items-center justify-center">
                    @if($vaccinated)
                        <svg class="w-7 h-7 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                    @else
                        <svg class="w-7 h-7 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                        </svg>
                    @endif
                </div>
            </div>
            @if(!$vaccinated)
                <a href="{{ route('patient.search') }}" class="inline-flex items-center gap-1 text-sm text-blue-600 font-medium mt-4 hover:underline group">
                    Book Vaccination
                    <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                </a>
            @endif
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm card-hover">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-gray-400 uppercase tracking-wider font-semibold">Test Results</p>
                    <div class="flex items-center gap-5 mt-2">
                        <div class="text-center">
                            <p class="text-xl font-bold text-red-600">{{ $positiveTests }}</p>
                            <p class="text-xs text-gray-400">Positive</p>
                        </div>
                        <div class="text-center">
                            <p class="text-xl font-bold text-emerald-600">{{ $negativeTests }}</p>
                            <p class="text-xs text-gray-400">Negative</p>
                        </div>
                        <div class="text-center">
                            <p class="text-xl font-bold text-amber-600">{{ $pending }}</p>
                            <p class="text-xs text-gray-400">Pending</p>
                        </div>
                    </div>
                </div>
                <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-blue-100 to-indigo-100 flex items-center justify-center">
                    <svg class="w-7 h-7 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <div data-aos="fade-up" data-aos-delay="200" class="grid grid-cols-1 md:grid-cols-3 gap-5">
        <a href="{{ route('patient.search') }}" class="group bg-white rounded-2xl border border-gray-100 p-6 card-hover shadow-sm">
            <div class="w-12 h-12 bg-gradient-to-br from-blue-100 to-indigo-100 text-blue-600 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>
            <h3 class="font-bold text-gray-900">Search Hospitals</h3>
            <p class="text-sm text-gray-500 mt-1">Find hospitals and book appointments</p>
            <span class="inline-flex items-center gap-1 text-sm text-blue-600 font-medium mt-3 group-hover:gap-2 transition-all">
                Get Started
                <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </span>
        </a>

        <a href="{{ route('patient.appointments') }}" class="group bg-white rounded-2xl border border-gray-100 p-6 card-hover shadow-sm">
            <div class="w-12 h-12 bg-gradient-to-br from-emerald-100 to-teal-100 text-emerald-600 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
            <h3 class="font-bold text-gray-900">My Appointments</h3>
            <p class="text-sm text-gray-500 mt-1">View and manage your bookings</p>
            <span class="inline-flex items-center gap-1 text-sm text-emerald-600 font-medium mt-3 group-hover:gap-2 transition-all">
                View All
                <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </span>
        </a>

        <a href="{{ route('patient.profile') }}" class="group bg-white rounded-2xl border border-gray-100 p-6 card-hover shadow-sm">
            <div class="w-12 h-12 bg-gradient-to-br from-purple-100 to-pink-100 text-purple-600 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
            </div>
            <h3 class="font-bold text-gray-900">My Profile</h3>
            <p class="text-sm text-gray-500 mt-1">Manage your account details</p>
            <span class="inline-flex items-center gap-1 text-sm text-purple-600 font-medium mt-3 group-hover:gap-2 transition-all">
                Update Profile
                <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </span>
        </a>
    </div>

    @if($appointments->count())
    <div data-aos="fade-up" data-aos-delay="250" class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between bg-gray-50/30">
            <div>
                <h3 class="font-bold text-gray-900">Recent Appointments</h3>
                <p class="text-xs text-gray-400">Your latest bookings</p>
            </div>
            <a href="{{ route('patient.appointments') }}" class="text-sm text-blue-600 hover:text-blue-700 font-medium hover:underline transition inline-flex items-center gap-1">
                View all
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gradient-to-r from-gray-50 to-gray-100/50 text-gray-600 text-xs uppercase tracking-wider">
                        <th class="text-left px-6 py-3 font-semibold">Hospital</th>
                        <th class="text-left px-6 py-3 font-semibold">Type</th>
                        <th class="text-left px-6 py-3 font-semibold">Date</th>
                        <th class="text-left px-6 py-3 font-semibold">Status</th>
                        <th class="text-left px-6 py-3 font-semibold">Result</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($appointments->take(5) as $a)
                    <tr class="hover:bg-blue-50/30 transition group">
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
                                $statusColors = ['approved' => 'bg-emerald-50 text-emerald-700 border-emerald-200', 'rejected' => 'bg-red-50 text-red-700 border-red-200', 'pending' => 'bg-amber-50 text-amber-700 border-amber-200'];
                                $statusDots = ['approved' => 'bg-emerald-500', 'rejected' => 'bg-red-500', 'pending' => 'bg-amber-500'];
                            @endphp
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium border {{ $statusColors[$a->status] ?? 'bg-gray-100 text-gray-600' }}">
                                <span class="w-1.5 h-1.5 rounded-full {{ $statusDots[$a->status] ?? 'bg-gray-400' }} {{ $a->status === 'pending' ? 'animate-pulse' : '' }}"></span>
                                {{ ucfirst($a->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            @if($a->test_result)
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium border
                                    @if($a->test_result === 'positive') bg-red-50 text-red-700 border-red-200
                                    @elseif($a->test_result === 'negative') bg-emerald-50 text-emerald-700 border-emerald-200
                                    @else bg-gray-50 text-gray-500 border-gray-200 @endif">
                                    <span class="w-1.5 h-1.5 rounded-full 
                                        @if($a->test_result === 'positive') bg-red-500
                                        @elseif($a->test_result === 'negative') bg-emerald-500
                                        @else bg-gray-400 @endif">
                                    </span>
                                    {{ ucfirst($a->test_result) }}
                                </span>
                            @else
                                <span class="text-xs text-gray-400">—</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @else
    <div data-aos="fade-up" data-aos-delay="250" class="bg-white rounded-2xl border border-gray-100 shadow-sm p-12 text-center">
        <div class="w-20 h-20 bg-gradient-to-br from-gray-100 to-gray-200 rounded-2xl flex items-center justify-center mx-auto mb-4">
            <svg class="w-10 h-10 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
        </div>
        <h3 class="text-xl font-bold text-gray-900 mb-1">No appointments yet</h3>
        <p class="text-gray-500 text-sm mb-6 max-w-sm mx-auto">Search for hospitals and book your first appointment to get started</p>
        <a href="{{ route('patient.search') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-blue-500 to-indigo-600 text-white font-semibold rounded-xl hover:from-blue-600 hover:to-indigo-700 transition shadow-lg shadow-blue-200/50 hover:shadow-blue-300/70 hover:-translate-y-0.5 text-sm">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            Search Hospitals
        </a>
    </div>
    @endif

    <div data-aos="fade-up" class="bg-gradient-to-r from-blue-50 to-indigo-50/50 rounded-2xl border border-blue-100 p-5 flex items-start gap-3">
        <div class="w-9 h-9 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center shrink-0 mt-0.5">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <div>
            <p class="text-sm font-semibold text-gray-800">Health Tip</p>
            <p class="text-sm text-gray-600">Stay protected! Get vaccinated, wear masks in crowded places, and maintain good hand hygiene. Your health is our priority.</p>
        </div>
    </div>
</div>
@endsection