@extends('layouts.patient')

@section('title', 'My Profile')
@section('page-title', 'My Profile')
@section('page-subtitle', 'Manage your account details and preferences')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <div data-aos="fade-down" class="hidden md:block">
        <h1 class="text-2xl md:text-3xl font-extrabold text-gray-900 tracking-tight">My Profile</h1>
        <p class="text-gray-500 text-sm mt-1">Manage your account details and preferences</p>
    </div>

    <div data-aos="fade-up" data-aos-delay="100" class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="bg-gradient-to-r from-blue-50 to-indigo-50/50 px-6 py-6 border-b border-gray-100">
            <div class="flex items-center gap-5">
                <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white text-2xl font-bold shadow-lg shadow-blue-200/50">
                    {{ strtoupper(substr($patient->name, 0, 2)) }}
                </div>
                <div>
                    <h2 class="text-xl font-bold text-gray-900">{{ $patient->name }}</h2>
                    <div class="flex flex-wrap items-center gap-2 mt-1">
                        <span class="text-sm text-gray-500 flex items-center gap-1">
                            <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/>
                            </svg>
                            {{ $patient->email }}
                        </span>
                        <span class="w-1 h-1 bg-gray-300 rounded-full"></span>
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700">
                            <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span>
                            Active
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="p-6">
            <form method="POST" action="{{ route('patient.profile.update') }}" class="space-y-5">
                @csrf
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                            <span class="flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                Full Name
                            </span>
                        </label>
                        <input type="text" name="name" value="{{ $patient->name }}" required
                            class="w-full px-4 py-3 bg-gray-50/50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-blue-400 focus:border-blue-400 outline-none transition-all duration-200 hover:border-gray-300">
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                            <span class="flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/>
                                </svg>
                                Email Address
                            </span>
                        </label>
                        <input type="email" value="{{ $patient->email }}" disabled
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm bg-gray-100 text-gray-500 cursor-not-allowed">
                        <p class="text-xs text-gray-400 mt-1.5">Email cannot be changed</p>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                            <span class="flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                </svg>
                                Phone
                            </span>
                        </label>
                        <input type="text" name="phone" value="{{ $patient->phone }}"
                            class="w-full px-4 py-3 bg-gray-50/50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-blue-400 focus:border-blue-400 outline-none transition-all duration-200 hover:border-gray-300">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                            <span class="flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                Location
                            </span>
                        </label>
                        <input type="text" name="location" value="{{ $patient->location }}"
                            class="w-full px-4 py-3 bg-gray-50/50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-blue-400 focus:border-blue-400 outline-none transition-all duration-200 hover:border-gray-300">
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                            <span class="flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                </svg>
                                Address
                            </span>
                        </label>
                        <input type="text" name="address" value="{{ $patient->address }}"
                            class="w-full px-4 py-3 bg-gray-50/50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-blue-400 focus:border-blue-400 outline-none transition-all duration-200 hover:border-gray-300">
                    </div>
                </div>

                <div class="flex items-center gap-3 pt-2">
                    <button type="submit" class="px-6 py-3 bg-gradient-to-r from-blue-500 to-indigo-600 text-white font-bold rounded-xl hover:from-blue-600 hover:to-indigo-700 transition-all duration-300 shadow-lg shadow-blue-200/50 hover:shadow-blue-300/70 hover:-translate-y-0.5 active:translate-y-0 active:shadow-md flex items-center gap-2 text-sm">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                        </svg>
                        Update Profile
                    </button>
                    <span class="text-xs text-gray-400">All fields are optional except name</span>
                </div>
            </form>
        </div>
    </div>

    <div data-aos="fade-up" data-aos-delay="150" class="bg-white rounded-2xl border border-red-100 shadow-sm overflow-hidden">
        <div class="px-6 py-5 border-b border-red-100 bg-red-50/30">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-lg bg-red-100 text-red-600 flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                    </svg>
                </div>
                <h3 class="font-bold text-red-700">Danger Zone</h3>
            </div>
        </div>
        <div class="px-6 py-5">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <p class="font-medium text-gray-900">Delete Account</p>
                    <p class="text-sm text-gray-500">Permanently delete your account and all associated data. This action cannot be undone.</p>
                </div>
                <form method="POST" action="{{ route('patient.profile.delete') }}" onsubmit="return confirm('Are you sure you want to delete your account? This action cannot be undone. All your data will be permanently removed.')">
                    @csrf
                    <button type="submit" class="px-5 py-2.5 bg-red-600 text-white font-semibold rounded-xl hover:bg-red-700 hover:shadow-lg hover:shadow-red-200/50 transition-all duration-200 hover:-translate-y-0.5 active:translate-y-0 flex items-center gap-2 text-sm whitespace-nowrap">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                        Delete Account
                    </button>
                </form>
            </div>
        </div>
    </div>

    <a href="{{ route('patient.dashboard') }}" class="inline-flex items-center gap-1.5 text-sm text-gray-500 hover:text-gray-700 transition bg-white px-4 py-2 rounded-xl border border-gray-200 hover:border-gray-300 shadow-sm hover:shadow">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M7 16l-4-4m0 0l4-4m-4 4h18"/>
        </svg>
        Back to Dashboard
    </a>
</div>
@endsection