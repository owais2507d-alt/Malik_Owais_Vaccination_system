@extends('layouts.admin')

@section('title', 'Reports - Admin Panel')
@section('page-title', 'Reports')
@section('page-subtitle', 'View and export appointment data')

@section('content')
<div class="space-y-6">
    <div data-aos="fade-down" class="flex justify-end">
        <a href="{{ route('admin.export') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-emerald-500 to-teal-600 text-white font-medium rounded-xl hover:from-emerald-600 hover:to-teal-700 transition shadow-sm text-sm">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
            </svg>
            Export as Excel
        </a>
    </div>

    @php
        $allAppts = $appointments;
        $filterStatus = request('status');
        $filterType = request('type');
        if ($filterStatus) {
            $allAppts = $allAppts->where('status', $filterStatus);
        }
        if ($filterType) {
            $allAppts = $allAppts->where('type', $filterType);
        }
    @endphp

    <div data-aos="fade-up" data-aos-delay="100" class="grid grid-cols-2 md:grid-cols-4 gap-4">
        @php
            $total = $allAppts->count();
            $approved = $allAppts->where('status', 'approved')->count();
            $pending = $allAppts->where('status', 'pending')->count();
            $rejected = $allAppts->where('status', 'rejected')->count();
        @endphp
        <div class="bg-white rounded-2xl border border-gray-100 p-5 shadow-sm card-hover">
            <p class="text-xs text-gray-400 uppercase tracking-wider font-semibold">Total</p>
            <p class="text-3xl font-extrabold text-gray-900 mt-1">{{ $total }}</p>
            <div class="mt-2 h-1.5 w-full bg-gray-100 rounded-full overflow-hidden">
                <div class="h-full w-full bg-blue-500 rounded-full progress-bar"></div>
            </div>
        </div>
        <div class="bg-white rounded-2xl border border-gray-100 p-5 shadow-sm card-hover">
            <p class="text-xs text-gray-400 uppercase tracking-wider font-semibold">Approved</p>
            <p class="text-3xl font-extrabold text-emerald-600 mt-1">{{ $approved }}</p>
            <div class="mt-2 h-1.5 w-full bg-gray-100 rounded-full overflow-hidden">
                <div class="h-full w-{{ $total > 0 ? round(($approved/$total)*100) : 0 }}% bg-emerald-500 rounded-full progress-bar"></div>
            </div>
        </div>
        <div class="bg-white rounded-2xl border border-gray-100 p-5 shadow-sm card-hover">
            <p class="text-xs text-gray-400 uppercase tracking-wider font-semibold">Pending</p>
            <p class="text-3xl font-extrabold text-amber-600 mt-1">{{ $pending }}</p>
            <div class="mt-2 h-1.5 w-full bg-gray-100 rounded-full overflow-hidden">
                <div class="h-full w-{{ $total > 0 ? round(($pending/$total)*100) : 0 }}% bg-amber-500 rounded-full progress-bar"></div>
            </div>
        </div>
        <div class="bg-white rounded-2xl border border-gray-100 p-5 shadow-sm card-hover">
            <p class="text-xs text-gray-400 uppercase tracking-wider font-semibold">Rejected</p>
            <p class="text-3xl font-extrabold text-red-600 mt-1">{{ $rejected }}</p>
            <div class="mt-2 h-1.5 w-full bg-gray-100 rounded-full overflow-hidden">
                <div class="h-full w-{{ $total > 0 ? round(($rejected/$total)*100) : 0 }}% bg-red-500 rounded-full progress-bar"></div>
            </div>
        </div>
    </div>

    <div data-aos="fade-up" data-aos-delay="150" class="bg-white rounded-2xl border border-gray-100 p-4 shadow-sm">
        <form method="GET" action="{{ route('admin.reports') }}" class="flex flex-wrap gap-3 items-end">
            <div>
                <label class="block text-xs font-medium text-gray-500 mb-1">Status</label>
                <select name="status" class="px-3 py-2 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-amber-400 focus:border-amber-400 outline-none transition">
                    <option value="">All Status</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                </select>
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-500 mb-1">Type</label>
                <select name="type" class="px-3 py-2 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-amber-400 focus:border-amber-400 outline-none transition">
                    <option value="">All Types</option>
                    <option value="test" {{ request('type') == 'test' ? 'selected' : '' }}>Test</option>
                    <option value="vaccination" {{ request('type') == 'vaccination' ? 'selected' : '' }}>Vaccination</option>
                </select>
            </div>
            <button type="submit" class="px-4 py-2 bg-gradient-to-r from-amber-500 to-orange-600 text-white text-sm font-medium rounded-xl hover:from-amber-600 hover:to-orange-700 transition shadow-sm">
                Filter
            </button>
            @if(request('status') || request('type'))
                <a href="{{ route('admin.reports') }}" class="px-4 py-2 bg-gray-100 text-gray-600 text-sm font-medium rounded-xl hover:bg-gray-200 transition">
                    Clear
                </a>
            @endif
        </form>
    </div>

    <div data-aos="fade-up" data-aos-delay="200" class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gradient-to-r from-gray-50 to-gray-100/50 text-gray-600 text-xs uppercase tracking-wider">
                        <th class="text-left px-6 py-4 font-semibold">#</th>
                        <th class="text-left px-6 py-4 font-semibold">Patient</th>
                        <th class="text-left px-6 py-4 font-semibold">Hospital</th>
                        <th class="text-left px-6 py-4 font-semibold">Type</th>
                        <th class="text-left px-6 py-4 font-semibold">Date</th>
                        <th class="text-left px-6 py-4 font-semibold">Status</th>
                        <th class="text-left px-6 py-4 font-semibold">Test Result</th>
                        <th class="text-left px-6 py-4 font-semibold">Vaccination</th>
                        <th class="text-left px-6 py-4 font-semibold">Created</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($allAppts as $a)
                    <tr class="hover:bg-amber-50/30 transition group">
                        <td class="px-6 py-4 text-gray-500 font-mono text-xs">#{{ str_pad($a->id, 4, '0', STR_PAD_LEFT) }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-blue-100 to-indigo-100 flex items-center justify-center text-xs font-bold text-blue-700 shrink-0">
                                    {{ strtoupper(substr($a->patient->name ?? 'N', 0, 1)) }}
                                </div>
                                <span class="font-medium text-gray-900">{{ $a->patient->name ?? 'N/A' }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-gray-600">{{ $a->hospital->hospital_name ?? 'N/A' }}</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium 
                                @if($a->type === 'test') bg-blue-50 text-blue-700
                                @else bg-purple-50 text-purple-700 @endif">
                                <span class="w-1.5 h-1.5 rounded-full 
                                    @if($a->type === 'test') bg-blue-500
                                    @else bg-purple-500 @endif"></span>
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
                        <td class="px-6 py-4">
                            @if($a->vaccination_status === 'vaccinated')
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700 border border-emerald-200">
                                    <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span>
                                    Vaccinated
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium bg-gray-50 text-gray-500 border border-gray-200">
                                    <span class="w-1.5 h-1.5 bg-gray-400 rounded-full"></span>
                                    Not Vaccinated
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-xs text-gray-400">
                            {{ $a->created_at->format('M d, Y') }}
                        </td>
                    </tr>
                    @endforeach
                    @if($allAppts->isEmpty())
                    <tr>
                        <td colspan="9" class="px-6 py-16 text-center">
                            <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            <p class="text-gray-500 font-medium">No appointments found</p>
                            <p class="text-sm text-gray-400 mt-1">{{ request('status') || request('type') ? 'No appointments match your filter criteria.' : 'Appointments will appear here once they are created' }}</p>
                        </td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>

    <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center gap-1.5 text-sm text-gray-500 hover:text-gray-700 transition bg-white px-4 py-2 rounded-xl border border-gray-200 hover:border-gray-300 shadow-sm hover:shadow">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M7 16l-4-4m0 0l4-4m-4 4h18"/>
        </svg>
        Back to Dashboard
    </a>
</div>

<style>
    .card-hover { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
    .card-hover:hover { transform: translateY(-4px); box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1), 0 10px 10px -5px rgba(0,0,0,0.04); }
    .progress-bar { transition: width 1s ease-in-out; }
</style>
@endsection