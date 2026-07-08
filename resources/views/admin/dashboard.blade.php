@extends('layouts.admin')

@section('title', 'Dashboard - Admin Panel')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Welcome back, ' . Auth::user()->name . '! Here\'s your platform overview.')

@section('content')
<div class="space-y-6">
    <div data-aos="fade-down" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        @php
            $stats = [
                ['label' => 'Total Patients', 'value' => number_format($totalPatients ?? 0), 'change' => '+12.5%', 'trend' => 'up', 'icon' => 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z', 'color' => 'blue'],
                ['label' => 'Total Hospitals', 'value' => number_format($totalHospitals ?? 0), 'change' => '+3', 'trend' => 'up', 'icon' => 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4', 'color' => 'emerald'],
                ['label' => 'Pending Approval', 'value' => number_format($pendingHospitals ?? 0), 'change' => 'Awaiting', 'trend' => 'neutral', 'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z', 'color' => 'amber'],
                ['label' => 'Appointments', 'value' => number_format($totalAppointments ?? 0), 'change' => '+8.2%', 'trend' => 'up', 'icon' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z', 'color' => 'purple'],
            ];
        @endphp
        @foreach($stats as $stat)
        <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm card-hover group">
            <div class="flex items-start justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-11 h-11 rounded-xl bg-{{ $stat['color'] }}-100 text-{{ $stat['color'] }}-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="{{ $stat['icon'] }}"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-gray-400 uppercase tracking-wider">{{ $stat['label'] }}</p>
                        <p class="text-2xl font-extrabold text-gray-900 mt-0.5">{{ $stat['value'] }}</p>
                    </div>
                </div>
                <span class="text-xs font-semibold px-2.5 py-1 rounded-full 
                    @if($stat['trend'] == 'up') bg-emerald-50 text-emerald-600
                    @elseif($stat['trend'] == 'down') bg-red-50 text-red-600
                    @else bg-amber-50 text-amber-600 @endif">
                    {{ $stat['change'] }}
                </span>
            </div>
            <div class="mt-3 h-1.5 w-full bg-gray-100 rounded-full overflow-hidden">
                <div class="h-full w-3/4 bg-{{ $stat['color'] }}-500 rounded-full progress-bar"></div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="grid lg:grid-cols-3 gap-6">
        <div data-aos="fade-up" data-aos-delay="100" class="lg:col-span-2 bg-white rounded-2xl border border-gray-100 p-6 shadow-sm">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-lg font-bold text-gray-900">Appointment Trends</h3>
                    <p class="text-sm text-gray-500">Weekly overview of appointments</p>
                </div>
                <select class="text-sm border border-gray-200 rounded-xl px-3 py-1.5 bg-gray-50 focus:ring-2 focus:ring-amber-400 focus:border-amber-400 outline-none transition">
                    <option>This Week</option>
                    <option>This Month</option>
                    <option>This Year</option>
                </select>
            </div>
            <div class="h-64 flex items-end justify-between gap-2 pt-4">
                @php
                    $days = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
                    $heights = [65, 45, 80, 55, 90, 40, 70];
                @endphp
                @foreach($days as $i => $day)
                <div class="flex-1 text-center group">
                    <div class="relative h-52 flex items-end justify-center">
                        <div class="w-full max-w-10 bg-gradient-to-t from-blue-500 to-blue-400 rounded-lg transition-all duration-300 hover:opacity-80 hover:scale-105 cursor-pointer" 
                             style="height: {{ $heights[$i] }}%; min-height: 20px;">
                            <div class="absolute -top-8 left-1/2 -translate-x-1/2 text-xs font-semibold text-gray-600 opacity-0 group-hover:opacity-100 transition bg-white px-2 py-0.5 rounded shadow-sm">
                                {{ $heights[$i] + 20 }}
                            </div>
                        </div>
                    </div>
                    <span class="text-xs text-gray-400 mt-2 block">{{ $day }}</span>
                </div>
                @endforeach
            </div>
        </div>

        <div data-aos="fade-up" data-aos-delay="150" class="space-y-5">
            <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-sm font-semibold text-gray-700">Pending Approvals</h3>
                    <span class="text-xs bg-amber-100 text-amber-700 px-2.5 py-1 rounded-full font-medium">{{ $pendingHospitals ?? 0 }}</span>
                </div>
                <div class="space-y-3">
                    <div class="flex items-center justify-between text-sm p-3 bg-amber-50 rounded-xl border border-amber-100">
                        <span class="text-gray-600 flex items-center gap-2">
                            <span class="w-2 h-2 bg-amber-500 rounded-full"></span>
                            Hospitals awaiting verification
                        </span>
                        <span class="font-semibold text-amber-600">{{ $pendingHospitals ?? 0 }}</span>
                    </div>
                    <div class="flex items-center justify-between text-sm p-3 bg-blue-50 rounded-xl border border-blue-100">
                        <span class="text-gray-600 flex items-center gap-2">
                            <span class="w-2 h-2 bg-blue-500 rounded-full"></span>
                            Vaccine requests pending
                        </span>
                        <span class="font-semibold text-blue-600">{{ $pendingVaccines ?? 0 }}</span>
                    </div>
                    <a href="{{ route('admin.hospitals') }}" class="block text-center text-sm text-amber-600 font-medium hover:text-amber-700 hover:underline mt-2 transition">
                        View all pending &rarr;
                    </a>
                </div>
            </div>

            <div class="bg-gradient-to-br from-amber-50 to-orange-50 rounded-2xl border border-amber-100 p-6 shadow-sm">
                <h3 class="text-sm font-semibold text-gray-700 mb-3 flex items-center gap-2">
                    <svg class="w-4 h-4 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                    Quick Actions
                </h3>
                <div class="grid grid-cols-2 gap-2.5">
                    <a href="{{ route('admin.hospitals') }}" class="text-center p-3 bg-white rounded-xl hover:shadow-md transition shadow-sm border border-gray-100 hover:border-amber-200 group">
                        <svg class="w-5 h-5 text-amber-600 mx-auto mb-1 group-hover:scale-110 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                        <span class="text-xs font-medium text-gray-700">Hospitals</span>
                    </a>
                    <a href="{{ route('admin.vaccines') }}" class="text-center p-3 bg-white rounded-xl hover:shadow-md transition shadow-sm border border-gray-100 hover:border-blue-200 group">
                        <svg class="w-5 h-5 text-blue-600 mx-auto mb-1 group-hover:scale-110 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                        </svg>
                        <span class="text-xs font-medium text-gray-700">Vaccines</span>
                    </a>
                    <a href="{{ route('admin.reports') }}" class="text-center p-3 bg-white rounded-xl hover:shadow-md transition shadow-sm border border-gray-100 hover:border-purple-200 group">
                        <svg class="w-5 h-5 text-purple-600 mx-auto mb-1 group-hover:scale-110 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        <span class="text-xs font-medium text-gray-700">Reports</span>
                    </a>
                    <a href="{{ route('admin.export') }}" class="text-center p-3 bg-white rounded-xl hover:shadow-md transition shadow-sm border border-gray-100 hover:border-emerald-200 group">
                        <svg class="w-5 h-5 text-emerald-600 mx-auto mb-1 group-hover:scale-110 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                        </svg>
                        <span class="text-xs font-medium text-gray-700">Export</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="grid lg:grid-cols-2 gap-6">
        <div data-aos="fade-up" data-aos-delay="200" class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h3 class="text-lg font-bold text-gray-900">Recent Activity</h3>
                    <p class="text-sm text-gray-500">Latest system activities</p>
                </div>
                <a href="#" class="text-sm text-amber-600 font-medium hover:text-amber-700 hover:underline">View all</a>
            </div>
            <div class="space-y-4">
                @php
                    $activities = [
                        ['icon' => 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4', 'color' => 'emerald', 'action' => 'City Hospital verified', 'time' => '2 min ago'],
                        ['icon' => 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z', 'color' => 'blue', 'action' => 'New patient registered: John Doe', 'time' => '15 min ago'],
                        ['icon' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z', 'color' => 'purple', 'action' => 'Appointment booked: Sarah Smith', 'time' => '1 hour ago'],
                        ['icon' => 'M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z', 'color' => 'amber', 'action' => 'Vaccine stock updated: Pfizer', 'time' => '3 hours ago'],
                    ];
                @endphp
                @foreach($activities as $activity)
                <div class="flex items-start gap-3 p-3 rounded-xl hover:bg-gray-50 transition">
                    <div class="w-8 h-8 rounded-lg bg-{{ $activity['color'] }}-100 text-{{ $activity['color'] }}-600 flex items-center justify-center shrink-0 mt-0.5">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="{{ $activity['icon'] }}"/>
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-800">{{ $activity['action'] }}</p>
                        <p class="text-xs text-gray-400">{{ $activity['time'] }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <div data-aos="fade-up" data-aos-delay="250" class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h3 class="text-lg font-bold text-gray-900">Top Hospitals</h3>
                    <p class="text-sm text-gray-500">Most active healthcare facilities</p>
                </div>
                <a href="{{ route('admin.hospitals') }}" class="text-sm text-amber-600 font-medium hover:text-amber-700 hover:underline">View all</a>
            </div>
            <div class="space-y-3">
                @php
                    $hospitalsList = [
                        ['name' => 'City General Hospital', 'patients' => '2,847', 'status' => 'Verified', 'color' => 'emerald'],
                        ['name' => 'St. Mary\'s Medical Center', 'patients' => '1,932', 'status' => 'Verified', 'color' => 'emerald'],
                        ['name' => 'Downtown Health Clinic', 'patients' => '1,204', 'status' => 'Pending', 'color' => 'amber'],
                        ['name' => 'Riverside Hospital', 'patients' => '986', 'status' => 'Verified', 'color' => 'emerald'],
                    ];
                @endphp
                @foreach($hospitalsList as $h)
                <div class="flex items-center justify-between p-3 rounded-xl hover:bg-gray-50 transition border border-transparent hover:border-gray-100">
                    <div class="flex items-center gap-3">
                        <div class="w-2 h-2 rounded-full bg-{{ $h['color'] }}-500"></div>
                        <div>
                            <p class="text-sm font-medium text-gray-800">{{ $h['name'] }}</p>
                            <p class="text-xs text-gray-400">{{ $h['patients'] }} patients</p>
                        </div>
                    </div>
                    <span class="text-xs font-medium px-2.5 py-1 rounded-full 
                        @if($h['status'] == 'Verified') bg-emerald-50 text-emerald-600
                        @else bg-amber-50 text-amber-600 @endif">
                        {{ $h['status'] }}
                    </span>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="text-center text-xs text-gray-400 py-4 border-t border-gray-100">
        <span class="flex items-center justify-center gap-2">
            <span class="w-1 h-1 bg-emerald-500 rounded-full animate-pulse"></span>
            System running smoothly &bull; All data is up to date
        </span>
    </div>
</div>

<style>
    .card-hover { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
    .card-hover:hover { transform: translateY(-4px); box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1), 0 10px 10px -5px rgba(0,0,0,0.04); }
    .progress-bar { transition: width 1s ease-in-out; }
</style>
@endsection