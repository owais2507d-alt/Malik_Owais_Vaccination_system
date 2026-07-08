@extends('layouts.app')

@section('title', 'Admin Login')

@section('content')
<div class="min-h-[75vh] flex items-center justify-center px-4 py-8">
    <div class="w-full max-w-6xl">
        {{-- Split Card --}}
        <div class="grid md:grid-cols-2 gap-0 bg-white rounded-3xl shadow-2xl border border-gray-100 overflow-hidden" 
             data-aos="fade-up" data-aos-duration="800">
            
            {{-- LEFT SIDE: Login Form --}}
            <div class="relative p-8 md:p-10 lg:p-12 bg-white">
                {{-- Decorative Elements --}}
                <div class="absolute -top-20 -right-20 w-64 h-64 bg-amber-200/10 rounded-full blur-3xl"></div>
                <div class="absolute -bottom-20 -left-20 w-64 h-64 bg-orange-200/10 rounded-full blur-3xl"></div>
                
                {{-- Header --}}
                <div class="relative text-center md:text-left mb-8">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-amber-100 to-orange-100 rounded-2xl mb-4 shadow-lg shadow-amber-200/50">
                        <svg class="w-8 h-8 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <h2 class="text-2xl md:text-3xl font-extrabold text-gray-900 tracking-tight">Admin Access</h2>
                    <p class="text-gray-500 text-sm mt-1">Secure system administration portal</p>
                    
                    {{-- Badge --}}
                    <div class="inline-flex items-center gap-1.5 mt-3 px-3 py-1 bg-amber-50 border border-amber-200 rounded-full">
                        <span class="w-1.5 h-1.5 bg-amber-500 rounded-full animate-pulse"></span>
                        <span class="text-xs font-medium text-amber-700">Restricted Access</span>
                    </div>
                </div>

                {{-- Form --}}
                <form method="POST" action="{{ route('admin.login.submit') }}" class="relative space-y-4">
                    @csrf
                    
                    {{-- Email Field --}}
                    <div class="group">
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                            <span class="flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/>
                                </svg>
                                Email Address
                            </span>
                        </label>
                        <div class="relative">
                            <input type="email" name="email" required placeholder="admin@covidcare.com"
                                class="w-full pl-4 pr-4 py-3 bg-gray-50/50 border border-gray-200 rounded-xl text-sm 
                                       focus:bg-white focus:ring-2 focus:ring-amber-400 focus:border-amber-400 
                                       outline-none transition-all duration-200 hover:border-gray-300
                                       placeholder:text-gray-400">
                            <div class="absolute inset-0 rounded-xl pointer-events-none ring-1 ring-transparent focus-within:ring-amber-400/50 transition"></div>
                        </div>
                    </div>

                    {{-- Password Field --}}
                    <div class="group">
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                            <span class="flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                                Password
                            </span>
                        </label>
                        <div class="relative">
                            <input type="password" name="password" required placeholder="••••••••"
                                class="w-full pl-4 pr-12 py-3 bg-gray-50/50 border border-gray-200 rounded-xl text-sm 
                                       focus:bg-white focus:ring-2 focus:ring-amber-400 focus:border-amber-400 
                                       outline-none transition-all duration-200 hover:border-gray-300
                                       placeholder:text-gray-400">
                            <button type="button" onclick="togglePassword(this)" 
                                    class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </button>
                            <div class="absolute inset-0 rounded-xl pointer-events-none ring-1 ring-transparent focus-within:ring-amber-400/50 transition"></div>
                        </div>
                    </div>

                    {{-- Remember Me --}}
                    <div class="flex items-center">
                        <label class="flex items-center gap-2 text-sm text-gray-600 cursor-pointer group">
                            <input type="checkbox" name="remember" 
                                   class="w-4 h-4 rounded border-gray-300 text-amber-600 focus:ring-amber-400 focus:ring-offset-0 
                                          transition group-hover:border-amber-400">
                            <span class="group-hover:text-gray-800 transition">Remember me</span>
                        </label>
                    </div>

                    {{-- Submit Button --}}
                    <button type="submit"
                        class="relative w-full py-3.5 bg-gradient-to-r from-amber-500 to-orange-600 text-white font-bold rounded-xl 
                               hover:from-amber-600 hover:to-orange-700 transition-all duration-300 shadow-lg shadow-amber-200/50 
                               hover:shadow-amber-300/70 hover:-translate-y-0.5 active:translate-y-0 active:shadow-md
                               flex items-center justify-center gap-2 text-sm tracking-wide group mt-2">
                        <span>Sign In to Admin Panel</span>
                        <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </button>

                    {{-- Divider --}}
                    <div class="relative my-4">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-200"></div>
                        </div>
                        <div class="relative flex justify-center text-xs">
                            <span class="px-3 bg-white text-gray-400">Secure connection</span>
                        </div>
                    </div>

                    {{-- Back to Home --}}
                    <div class="text-center">
                        <a href="{{ url('/') }}" class="inline-flex items-center gap-1.5 text-sm text-gray-500 hover:text-gray-700 transition">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                            </svg>
                            Back to Homepage
                        </a>
                    </div>
                </form>
            </div>

            {{-- RIGHT SIDE: Admin Banner --}}
            <div class="relative bg-gradient-to-br from-amber-600 via-orange-600 to-orange-700 p-8 md:p-10 lg:p-12 flex items-center justify-center overflow-hidden">
                {{-- Decorative Background Elements --}}
                <div class="absolute inset-0 opacity-10">
                    <div class="absolute top-10 left-10 w-72 h-72 bg-white rounded-full blur-3xl"></div>
                    <div class="absolute bottom-10 right-10 w-96 h-96 bg-white rounded-full blur-3xl"></div>
                    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-64 h-64 bg-white/5 rounded-full blur-2xl"></div>
                </div>

                {{-- Grid Pattern Overlay --}}
                <div class="absolute inset-0 opacity-5" style="background-image: radial-gradient(circle at 20px 20px, white 1.5px, transparent 1.5px); background-size: 40px 40px;"></div>

                {{-- Content --}}
                <div class="relative text-center text-white z-10">
                    {{-- Shield Icon --}}
                    <div class="inline-flex items-center justify-center w-24 h-24 bg-white/10 backdrop-blur-sm rounded-3xl mb-6 shadow-2xl border border-white/20">
                        <svg class="w-12 h-12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"/>
                        </svg>
                    </div>

                    <h3 class="text-2xl md:text-3xl font-bold mb-3">Admin Control Panel</h3>
                    <p class="text-orange-100/90 text-sm max-w-xs mx-auto leading-relaxed">
                        Complete oversight of hospitals, vaccine inventory, user management, and system analytics.
                    </p>

                    {{-- Feature List --}}
                    <div class="mt-6 space-y-3 text-left max-w-xs mx-auto">
                        <div class="flex items-center gap-3 bg-white/10 backdrop-blur-sm rounded-xl px-4 py-2.5 border border-white/10">
                            <svg class="w-5 h-5 text-amber-200 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span class="text-sm text-orange-50">Hospital verification &amp; oversight</span>
                        </div>
                        <div class="flex items-center gap-3 bg-white/10 backdrop-blur-sm rounded-xl px-4 py-2.5 border border-white/10">
                            <svg class="w-5 h-5 text-amber-200 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span class="text-sm text-orange-50">Vaccine inventory management</span>
                        </div>
                        <div class="flex items-center gap-3 bg-white/10 backdrop-blur-sm rounded-xl px-4 py-2.5 border border-white/10">
                            <svg class="w-5 h-5 text-amber-200 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span class="text-sm text-orange-50">Comprehensive reports &amp; analytics</span>
                        </div>
                        <div class="flex items-center gap-3 bg-white/10 backdrop-blur-sm rounded-xl px-4 py-2.5 border border-white/10">
                            <svg class="w-5 h-5 text-amber-200 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span class="text-sm text-orange-50">Export data to Excel</span>
                        </div>
                    </div>

                    {{-- Version Badge --}}
                    <div class="mt-8 inline-flex items-center gap-2 px-4 py-1.5 bg-white/10 backdrop-blur-sm rounded-full border border-white/10">
                        <span class="w-1.5 h-1.5 bg-emerald-400 rounded-full animate-pulse"></span>
                        <span class="text-xs text-orange-100/80">System v2.0 • Secure Access</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function togglePassword(btn) {
    const input = btn.closest('.relative').querySelector('input[type="password"], input[type="text"]');
    if (input.type === 'password') {
        input.type = 'text';
        btn.innerHTML = `<svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>`;
    } else {
        input.type = 'password';
        btn.innerHTML = `<svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>`;
    }
}
</script>

<style>
@keyframes shimmer {
    0% { background-position: -200% 0; }
    100% { background-position: 200% 0; }
}
.shimmer {
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.1), transparent);
    background-size: 200% 100%;
    animation: shimmer 2s infinite;
}
</style>
@endsection