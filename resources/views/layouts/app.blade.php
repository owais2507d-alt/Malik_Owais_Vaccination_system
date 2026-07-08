<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Covid Vaccination System')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <style>
        html { scroll-behavior: smooth; scroll-padding-top: 80px; }
        .nav-blur {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
        }
        .nav-link {
            position: relative;
            transition: all 0.2s ease;
        }
        .nav-link::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 0;
            height: 2px;
            background: linear-gradient(to right, #6366F1, #4F46E5);
            transition: width 0.3s ease;
            border-radius: 2px;
        }
        .nav-link:hover::after,
        .nav-link.active::after {
            width: 100%;
        }
        .nav-link.active {
            color: #4F46E5;
            font-weight: 600;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fadeIn {
            animation: fadeIn 0.3s ease-out;
        }
        .mobile-menu-item {
            transition: all 0.2s ease;
        }
        .mobile-menu-item:hover {
            transform: translateX(4px);
        }
        .card-hover {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .card-hover:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        .status-pulse {
            animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }
        .progress-bar {
            transition: width 1s ease-in-out;
        }
    </style>
</head>
<body class="font-sans antialiased bg-gray-50 text-gray-900">

    <nav class="fixed top-0 left-0 right-0 z-50 nav-blur border-b border-gray-100/80 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <a href="{{ url('/') }}" class="flex items-center gap-2 text-indigo-700 font-bold text-xl tracking-tight shrink-0 hover:text-indigo-800 transition">
                    <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                    CovidCare
                </a>

                @php
                    $authRoutes = ['patient.login', 'patient.register', 'hospital.login', 'hospital.register', 'admin.login'];
                    $isAuthPage = request()->routeIs(...$authRoutes);
                @endphp

                <div class="hidden md:flex items-center gap-1">
                    @if($isAuthPage)
                        <a href="{{ route('patient.login') }}" class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-indigo-600 transition nav-link">Patient</a>
                        <a href="{{ route('hospital.login') }}" class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-indigo-600 transition nav-link">Hospital</a>
                        <a href="{{ route('admin.login') }}" class="px-5 py-2 bg-gradient-to-r from-indigo-600 to-indigo-700 text-white text-sm font-semibold rounded-xl hover:from-indigo-700 hover:to-indigo-800 transition shadow-sm hover:shadow-md">Admin</a>
                    @else
                        @auth('web')
                            @php
                                $user = Auth::guard('web')->user();
                                $isAdmin = $user && method_exists($user, 'isAdmin') && $user->isAdmin();
                            @endphp
                            @if($isAdmin)
                                <x-nav-link href="{{ route('admin.dashboard') }}" :active="request()->routeIs('admin.dashboard')">Dashboard</x-nav-link>
                                <x-nav-link href="{{ route('admin.hospitals') }}" :active="request()->routeIs('admin.hospitals')">Hospitals</x-nav-link>
                                <x-nav-link href="{{ route('admin.vaccines') }}" :active="request()->routeIs('admin.vaccines')">Vaccines</x-nav-link>
                                <x-nav-link href="{{ route('admin.reports') }}" :active="request()->routeIs('admin.reports')">Reports</x-nav-link>
                                <x-nav-link href="{{ route('admin.export') }}" :active="request()->routeIs('admin.export')">Export</x-nav-link>
                                <form action="{{ route('admin.logout') }}" method="POST" class="inline">
                                    @csrf
                                    <button class="ml-2 px-5 py-2 bg-gradient-to-r from-indigo-600 to-indigo-700 text-white text-sm font-semibold rounded-xl hover:from-indigo-700 hover:to-indigo-800 transition shadow-sm hover:shadow-md flex items-center gap-1.5">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                        </svg>
                                        Logout
                                    </button>
                                </form>
                            @else
                                <x-nav-link href="{{ route('patient.dashboard') }}" :active="request()->routeIs('patient.dashboard')">Dashboard</x-nav-link>
                                <x-nav-link href="{{ route('patient.search') }}" :active="request()->routeIs('patient.search')">Search</x-nav-link>
                                <x-nav-link href="{{ route('patient.appointments') }}" :active="request()->routeIs('patient.appointments')">Appointments</x-nav-link>
                                <x-nav-link href="{{ route('patient.profile') }}" :active="request()->routeIs('patient.profile')">Profile</x-nav-link>
                                <form action="{{ route('patient.logout') }}" method="POST" class="inline">
                                    @csrf
                                    <button class="ml-2 px-5 py-2 bg-gradient-to-r from-indigo-600 to-indigo-700 text-white text-sm font-semibold rounded-xl hover:from-indigo-700 hover:to-indigo-800 transition shadow-sm hover:shadow-md flex items-center gap-1.5">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                        </svg>
                                        Logout
                                    </button>
                                </form>
                            @endif
                        @endauth

                        @auth('hospital')
                            <x-nav-link href="{{ route('hospital.dashboard') }}" :active="request()->routeIs('hospital.dashboard')">Dashboard</x-nav-link>
                            <x-nav-link href="{{ route('hospital.requests') }}" :active="request()->routeIs('hospital.requests')">Requests</x-nav-link>
                            <form action="{{ route('hospital.logout') }}" method="POST" class="inline">
                                @csrf
                                <button class="ml-2 px-5 py-2 bg-gradient-to-r from-indigo-600 to-indigo-700 text-white text-sm font-semibold rounded-xl hover:from-indigo-700 hover:to-indigo-800 transition shadow-sm hover:shadow-md flex items-center gap-1.5">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                    </svg>
                                    Logout
                                </button>
                            </form>
                        @endauth

                        @guest
                            <a href="{{ route('patient.login') }}" class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-indigo-600 transition nav-link">Patient</a>
                            <a href="{{ route('hospital.login') }}" class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-indigo-600 transition nav-link">Hospital</a>
                            <a href="{{ route('admin.login') }}" class="px-5 py-2 bg-gradient-to-r from-indigo-600 to-indigo-700 text-white text-sm font-semibold rounded-xl hover:from-indigo-700 hover:to-indigo-800 transition shadow-sm hover:shadow-md">Admin</a>
                        @endguest
                    @endif
                </div>

                <button id="mobile-menu-btn" class="md:hidden text-gray-600 hover:text-indigo-600 p-2 transition rounded-lg hover:bg-gray-100" onclick="document.getElementById('mobile-menu').classList.toggle('hidden')">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>

        <div id="mobile-menu" class="hidden md:hidden bg-white/95 backdrop-blur-lg border-t border-gray-100 px-4 py-3 space-y-1 shadow-lg">
            @if($isAuthPage)
                <a href="{{ route('patient.login') }}" class="mobile-menu-item block px-3 py-2.5 text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 rounded-lg transition font-medium">Patient Login</a>
                <a href="{{ route('hospital.login') }}" class="mobile-menu-item block px-3 py-2.5 text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 rounded-lg transition font-medium">Hospital Login</a>
                <a href="{{ route('admin.login') }}" class="mobile-menu-item block px-3 py-2.5 text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 rounded-lg transition font-medium">Admin Login</a>
            @else
                @auth('web')
                    @php
                        $user = Auth::guard('web')->user();
                        $isAdmin = $user && method_exists($user, 'isAdmin') && $user->isAdmin();
                    @endphp
                    @if($isAdmin)
                        <a href="{{ route('admin.dashboard') }}" class="mobile-menu-item block px-3 py-2.5 text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 rounded-lg transition font-medium">Dashboard</a>
                        <a href="{{ route('admin.hospitals') }}" class="mobile-menu-item block px-3 py-2.5 text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 rounded-lg transition font-medium">Hospitals</a>
                        <a href="{{ route('admin.vaccines') }}" class="mobile-menu-item block px-3 py-2.5 text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 rounded-lg transition font-medium">Vaccines</a>
                        <a href="{{ route('admin.reports') }}" class="mobile-menu-item block px-3 py-2.5 text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 rounded-lg transition font-medium">Reports</a>
                        <form action="{{ route('admin.logout') }}" method="POST" class="block">
                            @csrf
                            <button class="mobile-menu-item w-full text-left px-3 py-2.5 text-red-600 hover:bg-red-50 rounded-lg transition font-medium flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                </svg>
                                Logout
                            </button>
                        </form>
                    @else
                        <a href="{{ route('patient.dashboard') }}" class="mobile-menu-item block px-3 py-2.5 text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 rounded-lg transition font-medium">Dashboard</a>
                        <a href="{{ route('patient.search') }}" class="mobile-menu-item block px-3 py-2.5 text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 rounded-lg transition font-medium">Search</a>
                        <a href="{{ route('patient.appointments') }}" class="mobile-menu-item block px-3 py-2.5 text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 rounded-lg transition font-medium">Appointments</a>
                        <a href="{{ route('patient.profile') }}" class="mobile-menu-item block px-3 py-2.5 text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 rounded-lg transition font-medium">Profile</a>
                        <form action="{{ route('patient.logout') }}" method="POST" class="block">
                            @csrf
                            <button class="mobile-menu-item w-full text-left px-3 py-2.5 text-red-600 hover:bg-red-50 rounded-lg transition font-medium flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                </svg>
                                Logout
                            </button>
                        </form>
                    @endif
                @endauth

                @auth('hospital')
                    <a href="{{ route('hospital.dashboard') }}" class="mobile-menu-item block px-3 py-2.5 text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 rounded-lg transition font-medium">Dashboard</a>
                    <a href="{{ route('hospital.requests') }}" class="mobile-menu-item block px-3 py-2.5 text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 rounded-lg transition font-medium">Requests</a>
                    <form action="{{ route('hospital.logout') }}" method="POST" class="block">
                        @csrf
                        <button class="mobile-menu-item w-full text-left px-3 py-2.5 text-red-600 hover:bg-red-50 rounded-lg transition font-medium flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                            </svg>
                            Logout
                        </button>
                    </form>
                @endauth

                @guest
                    <a href="{{ route('patient.login') }}" class="mobile-menu-item block px-3 py-2.5 text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 rounded-lg transition font-medium">Patient Login</a>
                    <a href="{{ route('hospital.login') }}" class="mobile-menu-item block px-3 py-2.5 text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 rounded-lg transition font-medium">Hospital Login</a>
                    <a href="{{ route('admin.login') }}" class="mobile-menu-item block px-3 py-2.5 text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 rounded-lg transition font-medium">Admin Login</a>
                @endguest
            @endif
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-24 pb-8">
        @if(session('success'))
            <div data-aos="fade-down" class="mb-6 flex items-center gap-3 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl px-5 py-4 shadow-sm" role="alert">
                <svg class="w-5 h-5 text-emerald-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span class="text-sm font-medium">{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div data-aos="fade-down" class="mb-6 flex items-center gap-3 bg-red-50 border border-red-200 text-red-800 rounded-xl px-5 py-4 shadow-sm" role="alert">
                <svg class="w-5 h-5 text-red-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span class="text-sm font-medium">{{ session('error') }}</span>
            </div>
        @endif

        @yield('content')
    </main>

    <footer class="border-t border-gray-200 bg-white mt-12">
        <div class="max-w-7xl mx-auto px-4 py-6 text-center text-sm text-gray-500">
            &copy; {{ date('Y') }} CovidCare System. All rights reserved.
        </div>
    </footer>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({ once: true, offset: 50, duration: 600 });

        document.addEventListener('DOMContentLoaded', function() {
            const menuBtn = document.getElementById('mobile-menu-btn');
            const mobileMenu = document.getElementById('mobile-menu');

            document.addEventListener('click', function(event) {
                if (!menuBtn.contains(event.target) && !mobileMenu.contains(event.target)) {
                    mobileMenu.classList.add('hidden');
                }
            });

            document.addEventListener('keydown', function(event) {
                if (event.key === 'Escape') {
                    mobileMenu.classList.add('hidden');
                }
            });
        });
    </script>
</body>
</html>