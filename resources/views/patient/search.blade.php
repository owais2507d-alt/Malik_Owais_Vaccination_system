@extends('layouts.patient')

@section('title', 'Search Hospitals')
@section('page-title', 'Search Hospitals')
@section('page-subtitle', 'Find approved healthcare facilities near you')

@section('content')
<div class="space-y-6">
    <div data-aos="fade-down" class="hidden md:block">
        <h1 class="text-2xl md:text-3xl font-extrabold text-gray-900 tracking-tight">Search Hospitals</h1>
        <p class="text-gray-500 text-sm mt-1">Find approved healthcare facilities near you</p>
    </div>

    <div data-aos="fade-up" data-aos-delay="100" class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm">
        <form method="GET" action="{{ route('patient.search.submit') }}" class="flex flex-col sm:flex-row gap-3">
            <div class="flex-1 relative">
                <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <input type="text" name="query" value="{{ request('query') }}" placeholder="Search by hospital name or location..."
                    class="w-full pl-10 pr-4 py-3 bg-gray-50/50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-blue-400 focus:border-blue-400 outline-none transition-all duration-200 hover:border-gray-300 placeholder:text-gray-400">
            </div>
            <button type="submit" class="px-6 py-3 bg-gradient-to-r from-blue-500 to-indigo-600 text-white font-semibold rounded-xl hover:from-blue-600 hover:to-indigo-700 transition-all duration-300 shadow-sm hover:shadow-md flex items-center justify-center gap-2 text-sm whitespace-nowrap">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                Search
            </button>
        </form>
    </div>

    @if(request('query'))
        <div data-aos="fade-up" data-aos-delay="150" class="flex items-center justify-between">
            <h2 class="text-lg font-bold text-gray-900">
                Results
                <span class="text-gray-400 font-normal text-sm ml-2">({{ $hospitals->count() }} found)</span>
            </h2>
            <span class="text-xs text-gray-400 bg-gray-100 px-3 py-1 rounded-full">
                {{ $hospitals->count() > 0 ? 'Showing approved hospitals' : 'No results' }}
            </span>
        </div>

        @if($hospitals->count())
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                @foreach($hospitals as $i => $hospital)
                <div data-aos="fade-up" data-aos-delay="{{ $i * 80 }}" class="group bg-white rounded-2xl border border-gray-100 p-6 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 shadow-sm">
                    <div class="flex items-start gap-4">
                        <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-emerald-500 to-teal-600 flex items-center justify-center text-white font-bold text-xl shadow-lg shadow-emerald-200/50 shrink-0 group-hover:scale-110 transition-transform">
                            {{ strtoupper(substr($hospital->hospital_name, 0, 2)) }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <h3 class="font-bold text-gray-900 text-lg truncate">{{ $hospital->hospital_name }}</h3>
                            <div class="mt-1.5 space-y-1 text-sm text-gray-500">
                                @if($hospital->location)
                                    <span class="flex items-center gap-1.5">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                        {{ $hospital->location }}
                                    </span>
                                @endif
                                @if($hospital->address)
                                    <span class="flex items-center gap-1.5">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                        </svg>
                                        {{ $hospital->address }}
                                    </span>
                                @endif
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700 mt-1">
                                    <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span>
                                    Verified
                                </span>
                            </div>
                            <a href="{{ route('patient.book', $hospital->id) }}" class="mt-3 inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-blue-500 to-indigo-600 text-white text-sm font-semibold rounded-xl hover:from-blue-600 hover:to-indigo-700 transition-all duration-300 shadow-sm hover:shadow-md group-hover:shadow-blue-200/50">
                                Book Appointment
                                <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <div data-aos="fade-up" data-aos-delay="150" class="bg-white rounded-2xl border border-gray-100 shadow-sm p-12 text-center">
                <div class="w-20 h-20 bg-gradient-to-br from-gray-100 to-gray-200 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <svg class="w-10 h-10 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-1">No hospitals found</h3>
                <p class="text-gray-500 text-sm max-w-sm mx-auto">We couldn't find any hospitals matching your search. Try a different search term or location.</p>
                <a href="{{ route('patient.search') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-blue-500 to-indigo-600 text-white font-semibold rounded-xl hover:from-blue-600 hover:to-indigo-700 transition shadow-lg shadow-blue-200/50 hover:shadow-blue-300/70 hover:-translate-y-0.5 text-sm mt-4">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    Clear Search
                </a>
            </div>
        @endif
    @else
        <div data-aos="fade-up" data-aos-delay="100" class="bg-white rounded-2xl border border-gray-100 shadow-sm p-12 text-center">
            <div class="w-20 h-20 bg-gradient-to-br from-blue-100 to-indigo-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                <svg class="w-10 h-10 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>
            <h3 class="text-xl font-bold text-gray-900 mb-1">Find a hospital</h3>
            <p class="text-gray-500 text-sm max-w-sm mx-auto">Enter a hospital name or location above to search for approved healthcare facilities near you.</p>
        </div>
    @endif
</div>
@endsection