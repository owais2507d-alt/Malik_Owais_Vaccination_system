@extends('layouts.hospital')

@section('title', 'Hospital Dashboard')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Welcome back, {{ Auth::guard("hospital")->user()->hospital_name }}!')

@section('content')
<div class="space-y-6">
    <div data-aos="fade-down" class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div class="flex items-center gap-4">
            <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-emerald-500 to-teal-600 flex items-center justify-center text-white text-xl font-bold shadow-lg shadow-emerald-200/50">
                {{ strtoupper(substr(Auth::guard('hospital')->user()->hospital_name, 0, 2)) }}
            </div>
            <div>
                <h1 class="text-2xl md:text-3xl font-extrabold text-gray-900 tracking-tight">{{ Auth::guard('hospital')->user()->hospital_name }}</h1>
                <p class="text-gray-500 text-sm flex items-center gap-2 mt-0.5 flex-wrap">
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700">
                        <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span>
                        Hospital Dashboard
                    </span>
                    <span class="text-gray-300">•</span>
                    <span>{{ now()->format('l, M d, Y') }}</span>
                </p>
            </div>
        </div>
        <a href="{{ route('hospital.requests') }}" class="px-5 py-2.5 bg-gradient-to-r from-emerald-500 to-teal-600 text-white font-medium rounded-xl hover:from-emerald-600 hover:to-teal-700 transition shadow-sm hover:shadow-md flex items-center gap-2 text-sm whitespace-nowrap">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
            </svg>
            View All Requests
        </a>
    </div>

    <div data-aos="fade-up" data-aos-delay="100" class="grid grid-cols-1 md:grid-cols-3 gap-5">
        <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm card-hover group">
            <div class="flex items-start justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-xl bg-amber-100 text-amber-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-gray-400 uppercase tracking-wider">Pending Requests</p>
                        <p class="text-3xl font-extrabold text-gray-900 mt-0.5">{{ $pendingCount ?? 0 }}</p>
                    </div>
                </div>
                @if(($pendingCount ?? 0) > 0)
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-amber-100 text-amber-700">
                        <span class="w-1.5 h-1.5 bg-amber-500 rounded-full animate-pulse"></span>
                        Awaiting
                    </span>
                @endif
            </div>
            <div class="mt-4 h-1.5 w-full bg-gray-100 rounded-full overflow-hidden">
                <div class="h-full progress-bar" style="width: {{ min(($pendingCount ?? 0) * 20, 100) }}%" class="bg-amber-500 rounded-full"></div>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm card-hover group">
            <div class="flex items-start justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-gray-400 uppercase tracking-wider">Total Appointments</p>
                        <p class="text-3xl font-extrabold text-gray-900 mt-0.5">{{ $totalAppointments ?? 0 }}</p>
                    </div>
                </div>
                <span class="text-xs font-semibold text-emerald-600 bg-emerald-50 px-2.5 py-1 rounded-full">{{ ($totalAppointments ?? 0) > 0 ? 'Active' : 'No data' }}</span>
            </div>
            <div class="mt-4 h-1.5 w-full bg-gray-100 rounded-full overflow-hidden">
                <div class="h-full w-3/4 bg-blue-500 rounded-full progress-bar"></div>
            </div>
        </div>

        <a href="{{ route('hospital.requests') }}" class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm card-hover group">
            <div class="flex items-start justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-gray-400 uppercase tracking-wider">Quick Action</p>
                        <p class="text-xl font-bold text-gray-900 mt-0.5">Manage Requests</p>
                    </div>
                </div>
                <span class="inline-flex items-center gap-1 text-sm text-emerald-600 font-medium group-hover:gap-2 transition-all">
                    View
                    <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                    </svg>
                </span>
            </div>
            <div class="mt-4 h-1.5 w-full bg-gray-100 rounded-full overflow-hidden">
                <div class="h-full w-full bg-emerald-500 rounded-full progress-bar"></div>
            </div>
        </a>
    </div>

    @if(isset($recentRequests) && $recentRequests->count())
    <div data-aos="fade-up" data-aos-delay="150" class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between bg-gray-50/30">
            <div>
                <h3 class="font-bold text-gray-900">Recent Requests</h3>
                <p class="text-xs text-gray-400">Latest appointment requests</p>
            </div>
            <a href="{{ route('hospital.requests') }}" class="text-sm text-emerald-600 hover:text-emerald-700 font-medium hover:underline transition inline-flex items-center gap-1">
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
                        <th class="text-left px-6 py-3 font-semibold">Patient</th>
                        <th class="text-left px-6 py-3 font-semibold">Type</th>
                        <th class="text-left px-6 py-3 font-semibold">Date</th>
                        <th class="text-left px-6 py-3 font-semibold">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($recentRequests as $r)
                    <tr class="hover:bg-emerald-50/30 transition group">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-blue-100 to-indigo-100 flex items-center justify-center text-xs font-bold text-blue-700 shrink-0">
                                    {{ strtoupper(substr($r->patient->name, 0, 1)) }}
                                </div>
                                <span class="font-medium text-gray-900">{{ $r->patient->name }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium 
                                @if($r->type === 'test') bg-blue-50 text-blue-700
                                @else bg-purple-50 text-purple-700 @endif">
                                <span class="w-1.5 h-1.5 rounded-full 
                                    @if($r->type === 'test') bg-blue-500
                                    @else bg-purple-500 @endif">
                                </span>
                                {{ ucfirst($r->type) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-gray-600">{{ \Carbon\Carbon::parse($r->appointment_date)->format('M d, Y') }}</td>
                        <td class="px-6 py-4">
                            @php
                                $colors = ['approved' => 'bg-emerald-50 text-emerald-700 border-emerald-200', 'rejected' => 'bg-red-50 text-red-700 border-red-200', 'pending' => 'bg-amber-50 text-amber-700 border-amber-200'];
                                $statusDots = ['approved' => 'bg-emerald-500', 'rejected' => 'bg-red-500', 'pending' => 'bg-amber-500'];
                            @endphp
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium border {{ $colors[$r->status] ?? 'bg-gray-100 text-gray-600' }}">
                                <span class="w-1.5 h-1.5 rounded-full {{ $statusDots[$r->status] ?? 'bg-gray-400' }} {{ $r->status === 'pending' ? 'animate-pulse' : '' }}"></span>
                                {{ ucfirst($r->status) }}
                            </span>
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
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
            </svg>
        </div>
        <h3 class="text-xl font-bold text-gray-900 mb-1">No requests yet</h3>
        <p class="text-gray-500 text-sm max-w-sm mx-auto">Patient appointment requests will appear here once they are submitted.</p>
    </div>
    @endif

    <div class="text-center text-xs text-gray-400 py-4 border-t border-gray-100">
        <span class="flex items-center justify-center gap-2">
            <span class="w-1 h-1 bg-emerald-500 rounded-full animate-pulse"></span>
            System running smoothly &bull; All data is up to date
        </span>
    </div>
</div>
@endsection