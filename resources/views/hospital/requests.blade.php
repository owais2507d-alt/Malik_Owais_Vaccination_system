@extends('layouts.hospital')

@section('title', 'Appointment Requests')
@section('page-title', 'Manage Requests')
@section('page-subtitle', 'Manage patient appointments and update their status')

@section('content')
<div class="space-y-6">
    <div data-aos="fade-down" class="hidden md:flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-2xl md:text-3xl font-extrabold text-gray-900 tracking-tight">Appointment Requests</h1>
            <p class="text-gray-500 text-sm mt-1">Manage patient appointments and update their status</p>
        </div>
        <div class="flex items-center gap-3 flex-wrap">
            <span class="text-xs font-medium text-gray-600 bg-gray-100 px-3 py-1.5 rounded-full flex items-center gap-1.5">
                <span class="w-1.5 h-1.5 bg-amber-500 rounded-full animate-pulse"></span>
                {{ $appointments->where('status', 'pending')->count() }} Pending
            </span>
            <span class="text-xs font-medium text-gray-600 bg-gray-100 px-3 py-1.5 rounded-full flex items-center gap-1.5">
                <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span>
                {{ $appointments->where('status', 'approved')->count() }} Approved
            </span>
            <span class="text-xs font-medium text-gray-600 bg-gray-100 px-3 py-1.5 rounded-full flex items-center gap-1.5">
                <span class="w-1.5 h-1.5 bg-red-500 rounded-full"></span>
                {{ $appointments->where('status', 'rejected')->count() }} Rejected
            </span>
        </div>
    </div>

    @php
        $filtered = $appointments;
        $filterStatus = request('status');
        if ($filterStatus) {
            $filtered = $filtered->where('status', $filterStatus);
        }
    @endphp

    <div data-aos="fade-up" data-aos-delay="100" class="bg-white rounded-2xl border border-gray-100 p-4 shadow-sm">
        <form method="GET" action="{{ route('hospital.requests') }}" class="flex flex-wrap gap-3 items-end">
            <div>
                <label class="block text-xs font-medium text-gray-500 mb-1">Filter by Status</label>
                <select name="status" class="px-3 py-2 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-emerald-400 focus:border-emerald-400 outline-none transition">
                    <option value="">All Status</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                </select>
            </div>
            <button type="submit" class="px-4 py-2 bg-gradient-to-r from-emerald-500 to-teal-600 text-white text-sm font-medium rounded-xl hover:from-emerald-600 hover:to-teal-700 transition shadow-sm">
                Filter
            </button>
            @if(request('status'))
                <a href="{{ route('hospital.requests') }}" class="px-4 py-2 bg-gray-100 text-gray-600 text-sm font-medium rounded-xl hover:bg-gray-200 transition">
                    Clear
                </a>
            @endif
            <span class="text-xs text-gray-400 self-center ml-auto">{{ $filtered->count() }} request(s) found</span>
        </form>
    </div>

    @if($filtered->count())
    <div data-aos="fade-up" data-aos-delay="150" class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gradient-to-r from-gray-50 to-gray-100/50 text-gray-600 text-xs uppercase tracking-wider">
                        <th class="text-left px-6 py-4 font-semibold">Patient</th>
                        <th class="text-left px-6 py-4 font-semibold">Type</th>
                        <th class="text-left px-6 py-4 font-semibold">Date</th>
                        <th class="text-left px-6 py-4 font-semibold">Status</th>
                        <th class="text-left px-6 py-4 font-semibold">Test Result</th>
                        <th class="text-left px-6 py-4 font-semibold">Vaccination</th>
                        <th class="text-left px-6 py-4 font-semibold">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($filtered as $a)
                    <tr class="hover:bg-emerald-50/30 transition group">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-lg bg-gradient-to-br from-blue-100 to-indigo-100 flex items-center justify-center text-xs font-bold text-blue-700 shrink-0">
                                    {{ strtoupper(substr($a->patient->name, 0, 1)) }}
                                </div>
                                <div>
                                    <div class="font-medium text-gray-900">{{ $a->patient->name }}</div>
                                    <div class="text-xs text-gray-400">{{ $a->patient->email }}</div>
                                </div>
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
                                $sColors = ['approved' => 'bg-emerald-50 text-emerald-700 border-emerald-200', 'rejected' => 'bg-red-50 text-red-700 border-red-200', 'pending' => 'bg-amber-50 text-amber-700 border-amber-200'];
                                $sDots = ['approved' => 'bg-emerald-500', 'rejected' => 'bg-red-500', 'pending' => 'bg-amber-500'];
                            @endphp
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium border {{ $sColors[$a->status] ?? 'bg-gray-100 text-gray-600 border-gray-200' }}">
                                <span class="w-1.5 h-1.5 rounded-full {{ $sDots[$a->status] ?? 'bg-gray-400' }} {{ $a->status === 'pending' ? 'animate-pulse' : '' }}"></span>
                                {{ ucfirst($a->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            @if($a->test_result === 'positive')
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium border bg-red-50 text-red-700 border-red-200">
                                    <span class="w-1.5 h-1.5 bg-red-500 rounded-full"></span>
                                    Positive
                                </span>
                            @elseif($a->test_result === 'negative')
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium border bg-emerald-50 text-emerald-700 border-emerald-200">
                                    <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span>
                                    Negative
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium border bg-gray-50 text-gray-500 border-gray-200">
                                    <span class="w-1.5 h-1.5 bg-gray-400 rounded-full"></span>
                                    Pending
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            @if($a->vaccination_status === 'vaccinated')
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium border bg-emerald-50 text-emerald-700 border-emerald-200">
                                    <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span>
                                    Vaccinated
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium border bg-gray-50 text-gray-500 border-gray-200">
                                    <span class="w-1.5 h-1.5 bg-gray-400 rounded-full"></span>
                                    Not Vaccinated
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex flex-wrap gap-1.5">
                                @if($a->status === 'pending')
                                    <form method="POST" action="{{ route('hospital.request.approve', $a->id) }}" class="inline">
                                        @csrf
                                        <button class="px-3 py-1.5 bg-emerald-500 text-white text-xs font-medium rounded-lg hover:bg-emerald-600 hover:shadow-md transition shadow-sm flex items-center gap-1">
                                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                            </svg>
                                            Approve
                                        </button>
                                    </form>
                                    <form method="POST" action="{{ route('hospital.request.reject', $a->id) }}" class="inline">
                                        @csrf
                                        <button class="px-3 py-1.5 bg-red-500 text-white text-xs font-medium rounded-lg hover:bg-red-600 hover:shadow-md transition shadow-sm flex items-center gap-1">
                                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                                            </svg>
                                            Reject
                                        </button>
                                    </form>
                                @endif

                                @if($a->status === 'approved' && ($a->test_result === null || $a->test_result === 'pending'))
                                    <form method="POST" action="{{ route('hospital.request.test-result', $a->id) }}" class="inline-flex items-center gap-1">
                                        @csrf
                                        <select name="test_result" required
                                            class="px-2 py-1.5 border border-gray-300 rounded-lg text-xs focus:ring-2 focus:ring-blue-500 outline-none bg-white hover:border-gray-400 transition">
                                            <option value="">Result</option>
                                            <option value="negative">Negative</option>
                                            <option value="positive">Positive</option>
                                        </select>
                                        <button class="px-3 py-1.5 bg-blue-500 text-white text-xs font-medium rounded-lg hover:bg-blue-600 hover:shadow-md transition shadow-sm">
                                            Set
                                        </button>
                                    </form>
                                @endif

                                @if($a->status === 'approved' && ($a->vaccination_status === null || $a->vaccination_status === 'not_vaccinated'))
                                    <form method="POST" action="{{ route('hospital.request.vaccination', $a->id) }}" class="inline">
                                        @csrf
                                        <input type="hidden" name="vaccination_status" value="vaccinated">
                                        <button class="px-3 py-1.5 bg-amber-500 text-white text-xs font-medium rounded-lg hover:bg-amber-600 hover:shadow-md transition shadow-sm flex items-center gap-1">
                                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                            </svg>
                                            Mark Vaccinated
                                        </button>
                                    </form>
                                @endif
                            </div>
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
        <h3 class="text-xl font-bold text-gray-900 mb-1">No requests yet</h3>
        <p class="text-gray-500 text-sm max-w-sm mx-auto">{{ request('status') ? 'No requests match the selected filter.' : 'Patient appointment requests will appear here once they are submitted.' }}</p>
    </div>
    @endif

    <a href="{{ route('hospital.dashboard') }}" class="inline-flex items-center gap-1.5 text-sm text-gray-500 hover:text-gray-700 transition bg-white px-4 py-2 rounded-xl border border-gray-200 hover:border-gray-300 shadow-sm hover:shadow">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M7 16l-4-4m0 0l4-4m-4 4h18"/>
        </svg>
        Back to Dashboard
    </a>
</div>
@endsection