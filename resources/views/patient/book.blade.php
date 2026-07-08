@extends('layouts.patient')

@section('title', 'Book Appointment')
@section('page-title', 'Book Appointment')
@section('page-subtitle', 'Schedule a test or vaccination')

@section('content')
<div class="min-h-[75vh] flex items-center justify-center px-4">
    <div class="w-full max-w-2xl">
        <div data-aos="fade-down" class="mb-8 text-center">
            <div class="inline-flex items-center justify-center w-14 h-14 bg-gradient-to-br from-blue-100 to-indigo-100 rounded-2xl mb-4 shadow-lg shadow-blue-200/50">
                <svg class="w-7 h-7 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
            <h1 class="text-2xl md:text-3xl font-extrabold text-gray-900 tracking-tight">Book Appointment</h1>
            <p class="text-gray-500 text-sm mt-1">Schedule a test or vaccination at your preferred hospital</p>
        </div>

        <div data-aos="fade-up" data-aos-delay="100" class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden mb-6">
            <div class="bg-gradient-to-r from-blue-50 to-indigo-50/50 px-6 py-5 border-b border-gray-100">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white font-bold text-xl shadow-lg shadow-blue-200/50 shrink-0">
                        {{ strtoupper(substr($hospital->hospital_name, 0, 2)) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <h2 class="text-lg font-bold text-gray-900 truncate">{{ $hospital->hospital_name }}</h2>
                        <div class="flex flex-wrap items-center gap-2 mt-0.5">
                            @if($hospital->location)
                            <span class="text-sm text-gray-500 flex items-center gap-1">
                                <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                {{ $hospital->location }}
                            </span>
                            @endif
                            <span class="w-1 h-1 bg-gray-300 rounded-full"></span>
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700">
                                <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span>
                                Verified
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="p-6">
                <form method="POST" action="{{ route('patient.book.submit') }}" class="space-y-5">
                    @csrf
                    <input type="hidden" name="hospital_id" value="{{ $hospital->id }}">

                    <div class="group">
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                            <span class="flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                </svg>
                                Appointment Type
                            </span>
                        </label>
                        <select name="type" required
                            class="w-full px-4 py-3 bg-gray-50/50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-blue-400 focus:border-blue-400 outline-none transition-all duration-200 hover:border-gray-300">
                            <option value="">Select appointment type</option>
                            <option value="test">Covid Test</option>
                            <option value="vaccination">Vaccination</option>
                        </select>
                    </div>

                    <div class="group">
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                            <span class="flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                Preferred Date
                            </span>
                        </label>
                        <input type="date" name="appointment_date" required
                            min="{{ date('Y-m-d') }}"
                            class="w-full px-4 py-3 bg-gray-50/50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-blue-400 focus:border-blue-400 outline-none transition-all duration-200 hover:border-gray-300">
                        <p class="text-xs text-gray-400 mt-1.5">Please select a date from today onwards</p>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-3 pt-3">
                        <button type="submit" class="flex-1 px-6 py-3 bg-gradient-to-r from-blue-500 to-indigo-600 text-white font-bold rounded-xl hover:from-blue-600 hover:to-indigo-700 transition-all duration-300 shadow-lg shadow-blue-200/50 hover:shadow-blue-300/70 hover:-translate-y-0.5 active:translate-y-0 active:shadow-md flex items-center justify-center gap-2 text-sm group">
                            <svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Confirm Booking
                        </button>
                        <a href="{{ route('patient.search') }}" class="px-6 py-3 bg-white border border-gray-200 text-gray-700 font-medium rounded-xl hover:bg-gray-50 hover:border-gray-300 transition shadow-sm flex items-center justify-center gap-2 text-sm">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <div data-aos="fade-up" class="bg-gradient-to-br from-blue-50 to-indigo-50/50 rounded-2xl border border-blue-100 p-4 text-center">
            <p class="text-sm text-gray-600">
                <span class="font-semibold text-gray-800">Need help?</span>
                Contact us at 
                <a href="mailto:support@covidcare.com" class="text-blue-600 font-medium hover:underline">support@covidcare.com</a>
                or call 
                <a href="tel:1800028443" class="text-blue-600 font-medium hover:underline">1-800-COVID-HELP</a>
            </p>
        </div>
    </div>
</div>
@endsection