@extends('layouts.admin')

@section('title', 'Manage Vaccines - Admin Panel')
@section('page-title', 'Manage Vaccines')
@section('page-subtitle', 'Control vaccine inventory and availability')

@section('content')
<div class="space-y-6">
    <div data-aos="fade-down" class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm">
        <div class="flex items-center gap-3 mb-4">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-100 to-indigo-100 flex items-center justify-center">
                <svg class="w-5 h-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <h3 class="font-bold text-gray-900">Add New Vaccine</h3>
        </div>
        <form method="POST" action="{{ route('admin.vaccines.store') }}" class="flex flex-col sm:flex-row gap-3">
            @csrf
            <div class="flex-1">
                <input type="text" name="vaccine_name" placeholder="Enter vaccine name..." required
                    class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-amber-400 focus:border-amber-400 outline-none transition placeholder:text-gray-400">
            </div>
            <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-amber-500 to-orange-600 text-white font-medium rounded-xl hover:from-amber-600 hover:to-orange-700 transition shadow-sm hover:shadow-md flex items-center justify-center gap-2 text-sm whitespace-nowrap">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Add Vaccine
            </button>
        </form>
    </div>

    <div data-aos="fade-up" data-aos-delay="100" class="grid grid-cols-2 md:grid-cols-3 gap-4">
        @php
            $total = $vaccines->count();
            $available = $vaccines->where('status', 'available')->count();
            $unavailable = $vaccines->where('status', 'unavailable')->count();
        @endphp
        <div class="bg-white rounded-2xl border border-gray-100 p-5 shadow-sm card-hover">
            <div class="flex items-center justify-between mb-2">
                <p class="text-xs text-gray-400 uppercase tracking-wider font-semibold">Total</p>
                <svg class="w-5 h-5 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                </svg>
            </div>
            <p class="text-3xl font-extrabold text-gray-900">{{ $total }}</p>
            <div class="mt-2 h-1.5 w-full bg-gray-100 rounded-full overflow-hidden">
                <div class="h-full w-full bg-amber-500 rounded-full progress-bar"></div>
            </div>
        </div>
        <div class="bg-white rounded-2xl border border-gray-100 p-5 shadow-sm card-hover">
            <div class="flex items-center justify-between mb-2">
                <p class="text-xs text-gray-400 uppercase tracking-wider font-semibold">Available</p>
                <svg class="w-5 h-5 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <p class="text-3xl font-extrabold text-emerald-600">{{ $available }}</p>
            <div class="mt-2 h-1.5 w-full bg-gray-100 rounded-full overflow-hidden">
                <div class="h-full w-{{ $total > 0 ? round(($available/$total)*100) : 0 }}% bg-emerald-500 rounded-full progress-bar"></div>
            </div>
        </div>
        <div class="bg-white rounded-2xl border border-gray-100 p-5 shadow-sm card-hover">
            <div class="flex items-center justify-between mb-2">
                <p class="text-xs text-gray-400 uppercase tracking-wider font-semibold">Unavailable</p>
                <svg class="w-5 h-5 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <p class="text-3xl font-extrabold text-red-600">{{ $unavailable }}</p>
            <div class="mt-2 h-1.5 w-full bg-gray-100 rounded-full overflow-hidden">
                <div class="h-full w-{{ $total > 0 ? round(($unavailable/$total)*100) : 0 }}% bg-red-500 rounded-full progress-bar"></div>
            </div>
        </div>
    </div>

    <div data-aos="fade-up" data-aos-delay="150" class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gradient-to-r from-gray-50 to-gray-100/50 text-gray-600 text-xs uppercase tracking-wider">
                        <th class="text-left px-6 py-4 font-semibold">#</th>
                        <th class="text-left px-6 py-4 font-semibold">Vaccine Name</th>
                        <th class="text-left px-6 py-4 font-semibold">Status</th>
                        <th class="text-left px-6 py-4 font-semibold">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($vaccines as $v)
                    <tr class="hover:bg-amber-50/30 transition group">
                        <td class="px-6 py-4 text-gray-500 font-mono text-xs">#{{ str_pad($v->id, 4, '0', STR_PAD_LEFT) }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-{{ $v->status === 'available' ? 'emerald' : 'red' }}-100 to-{{ $v->status === 'available' ? 'teal' : 'rose' }}-100 flex items-center justify-center text-xs font-bold text-{{ $v->status === 'available' ? 'emerald' : 'red' }}-700 shrink-0">
                                    {{ strtoupper(substr($v->vaccine_name, 0, 2)) }}
                                </div>
                                <span class="font-medium text-gray-900">{{ $v->vaccine_name }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium border 
                                @if($v->status === 'available') bg-emerald-50 text-emerald-700 border-emerald-200
                                @else bg-red-50 text-red-700 border-red-200 @endif">
                                <span class="w-1.5 h-1.5 rounded-full 
                                    @if($v->status === 'available') bg-emerald-500
                                    @else bg-red-500 @endif">
                                </span>
                                {{ ucfirst($v->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <a href="{{ route('admin.vaccines.toggle', $v->id) }}"
                                class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-lg text-xs font-medium transition shadow-sm
                                    @if($v->status === 'available') bg-amber-100 text-amber-700 hover:bg-amber-200 hover:shadow
                                    @else bg-emerald-100 text-emerald-700 hover:bg-emerald-200 hover:shadow @endif">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                                </svg>
                                {{ $v->status === 'available' ? 'Set Unavailable' : 'Set Available' }}
                            </a>
                        </td>
                    </tr>
                    @endforeach
                    @if($vaccines->isEmpty())
                    <tr>
                        <td colspan="4" class="px-6 py-16 text-center">
                            <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                            </svg>
                            <p class="text-gray-500 font-medium">No vaccines available</p>
                            <p class="text-sm text-gray-400 mt-1">Add your first vaccine using the form above</p>
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