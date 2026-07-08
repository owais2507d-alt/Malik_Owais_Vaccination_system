<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Patient Panel - CovidCare')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.8/dist/cdn.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <style>
        html { scroll-behavior: smooth; }
        .sidebar-transition {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .sidebar-item {
            transition: all 0.2s ease;
        }
        .sidebar-item:hover {
            transform: translateX(4px);
        }
        .sidebar-item.active {
            background: linear-gradient(135deg, rgba(99, 102, 241, 0.12), rgba(79, 70, 229, 0.08));
            border-right: 3px solid #6366F1;
        }
        .sidebar-item.active .sidebar-icon {
            color: #6366F1;
        }
        .sidebar-item.active span {
            color: #6366F1;
            font-weight: 600;
        }
        [x-cloak] { display: none !important; }
        .scrollbar-hide::-webkit-scrollbar {
            width: 0;
            background: transparent;
        }
        .scrollbar-hide {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fadeIn {
            animation: fadeIn 0.3s ease-out;
        }
        .card-hover {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .card-hover:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
    </style>
</head>
<body class="font-sans antialiased bg-gray-50 text-gray-900">

    <div id="sidebarOverlay" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-40 hidden lg:hidden" onclick="toggleSidebar()"></div>

    <div class="flex h-screen overflow-hidden">
        <aside id="sidebar" class="fixed lg:relative z-50 w-72 h-full bg-white border-r border-gray-200 shadow-xl lg:shadow-none flex-shrink-0 -translate-x-full lg:translate-x-0 sidebar-transition overflow-y-auto scrollbar-hide">
            <div class="sticky top-0 bg-white/95 backdrop-blur-sm z-10 border-b border-gray-100 px-6 py-5">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center shadow-lg shadow-blue-200/50">
                        <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-lg font-extrabold text-gray-900 tracking-tight">Patient Portal</h1>
                        <p class="text-xs text-gray-400">CovidCare System</p>
                    </div>
                </div>
                <button onclick="toggleSidebar()" class="absolute right-4 top-5 lg:hidden p-1.5 hover:bg-gray-100 rounded-lg transition text-gray-400 hover:text-gray-600">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <div class="px-4 py-4 border-b border-gray-100">
                <div class="flex items-center gap-3 px-3 py-2.5 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl border border-blue-100">
                    <div class="w-9 h-9 rounded-lg bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white text-sm font-bold shadow-sm">
                        {{ strtoupper(substr(Auth::user()->name ?? 'P', 0, 1)) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-gray-900 truncate">{{ Auth::user()->name ?? 'Patient' }}</p>
                        <p class="text-xs text-gray-400 truncate">{{ Auth::user()->email }}</p>
                    </div>
                    <span class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></span>
                </div>
            </div>

            <nav class="px-3 py-4 space-y-1">
                @php
                    $navItems = [
                        ['route' => 'patient.dashboard', 'icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6', 'label' => 'Dashboard'],
                        ['route' => 'patient.search', 'icon' => 'M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z', 'label' => 'Search Hospitals'],
                        ['route' => 'patient.appointments', 'icon' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z', 'label' => 'My Appointments'],
                        ['route' => 'patient.profile', 'icon' => 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z', 'label' => 'My Profile'],
                    ];
                @endphp
                @foreach($navItems as $item)
                    <a href="{{ route($item['route']) }}" 
                       class="sidebar-item flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium text-gray-600 hover:text-gray-900 hover:bg-gray-50/80 transition-all duration-200 group {{ request()->routeIs($item['route']) ? 'active' : '' }}">
                        <svg class="sidebar-icon w-5 h-5 text-gray-400 group-hover:text-blue-500 transition-colors {{ request()->routeIs($item['route']) ? 'text-blue-500' : '' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="{{ $item['icon'] }}"/>
                        </svg>
                        <span>{{ $item['label'] }}</span>
                        @if(request()->routeIs($item['route']))
                            <span class="ml-auto w-1.5 h-1.5 bg-blue-500 rounded-full"></span>
                        @endif
                    </a>
                @endforeach
            </nav>

            <div class="absolute bottom-0 left-0 right-0 p-4 border-t border-gray-100 bg-white/95 backdrop-blur-sm">
                <a href="{{ url('/') }}" class="flex items-center gap-3 w-full px-3.5 py-2.5 rounded-xl text-sm font-medium text-gray-500 hover:bg-gray-50 transition-all duration-200 group mb-1">
                    <svg class="w-5 h-5 text-gray-400 group-hover:text-gray-600 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    <span>Home</span>
                </a>
                <form action="{{ route('patient.logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="flex items-center gap-3 w-full px-3.5 py-2.5 rounded-xl text-sm font-medium text-red-600 hover:bg-red-50 transition-all duration-200 group">
                        <svg class="w-5 h-5 text-red-400 group-hover:text-red-600 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </aside>

        <div class="flex-1 flex flex-col min-w-0">
            <nav class="sticky top-0 z-30 bg-white/80 backdrop-blur-lg border-b border-gray-100/80 px-4 sm:px-6 py-3.5">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <button onclick="toggleSidebar()" class="lg:hidden p-2 hover:bg-gray-100 rounded-xl transition text-gray-500 hover:text-gray-700">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                            </svg>
                        </button>
                        <div>
                            <h2 class="text-sm font-semibold text-gray-900">@yield('page-title', 'Dashboard')</h2>
                            <p class="text-xs text-gray-400 hidden sm:block">@yield('page-subtitle', 'Your health hub')</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="text-xs text-gray-400 hidden md:block">{{ now()->format('l, M d, Y') }}</span>

                        {{-- Notification Bell --}}
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="relative p-2 hover:bg-gray-100 rounded-xl transition text-gray-500 hover:text-gray-700">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                                </svg>
                                @php
                                    $pUser = Auth::user();
                                    $pNotifCount = $pUser ? \App\Helpers\NotificationHelper::unreadCount($pUser) : 0;
                                @endphp
                                @if($pNotifCount > 0)
                                    <span class="absolute -top-0.5 -right-0.5 w-5 h-5 bg-red-500 text-white text-[10px] font-bold rounded-full flex items-center justify-center">{{ $pNotifCount > 9 ? '9+' : $pNotifCount }}</span>
                                @endif
                            </button>
                            <div x-show="open" @click.away="open = false" x-cloak
                                 class="absolute right-0 mt-2 w-80 bg-white rounded-2xl shadow-2xl border border-gray-100 overflow-hidden z-50"
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 scale-95"
                                 x-transition:enter-end="opacity-100 scale-100">
                                <div class="px-4 py-3 border-b border-gray-100 flex items-center justify-between bg-gray-50/50">
                                    <h3 class="text-sm font-bold text-gray-900">Notifications</h3>
                                    @if($pNotifCount > 0)
                                        <span class="text-xs bg-amber-100 text-amber-700 px-2 py-0.5 rounded-full font-medium">{{ $pNotifCount }} new</span>
                                    @endif
                                </div>
                                <div class="max-h-72 overflow-y-auto divide-y divide-gray-50">
                                    @php $pNotifs = $pUser ? \App\Helpers\NotificationHelper::getRecent($pUser, 5) : collect(); @endphp
                                    @forelse($pNotifs as $notif)
                                        <div class="px-4 py-3 hover:bg-gray-50 transition {{ !$notif->is_read ? 'bg-blue-50/30' : '' }}">
                                            <div class="flex items-start gap-3">
                                                <div class="w-7 h-7 rounded-lg flex items-center justify-center shrink-0 mt-0.5
                                                    @if(str_contains($notif->type, 'approved')) bg-emerald-100 text-emerald-600
                                                    @elseif(str_contains($notif->type, 'rejected')) bg-red-100 text-red-600
                                                    @elseif(str_contains($notif->type, 'vaccine') || str_contains($notif->type, 'vaccination')) bg-purple-100 text-purple-600
                                                    @elseif(str_contains($notif->type, 'test')) bg-blue-100 text-blue-600
                                                    @else bg-gray-100 text-gray-600 @endif">
                                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                        @if(str_contains($notif->type, 'approved'))
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                        @elseif(str_contains($notif->type, 'rejected'))
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                        @elseif(str_contains($notif->type, 'test'))
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                                        @else
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                        @endif
                                                    </svg>
                                                </div>
                                                <div class="flex-1 min-w-0">
                                                    <p class="text-xs font-semibold text-gray-900">{{ $notif->title }}</p>
                                                    <p class="text-xs text-gray-500 mt-0.5 line-clamp-2">{{ $notif->message }}</p>
                                                    <p class="text-[10px] text-gray-400 mt-1">{{ $notif->created_at->diffForHumans() }}</p>
                                                </div>
                                                @if(!$notif->is_read)
                                                    <span class="w-2 h-2 bg-blue-500 rounded-full shrink-0 mt-1.5"></span>
                                                @endif
                                            </div>
                                            @if($notif->link)
                                                <a href="{{ $notif->link }}" class="text-[10px] text-blue-600 hover:underline mt-1 inline-block font-medium">View details &rarr;</a>
                                            @endif
                                        </div>
                                    @empty
                                        <div class="px-4 py-8 text-center text-sm text-gray-400">
                                            <svg class="w-8 h-8 mx-auto text-gray-300 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                                            </svg>
                                            No notifications yet
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>

                        <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-blue-100 to-indigo-100 flex items-center justify-center text-blue-700 text-xs font-bold">
                            {{ strtoupper(substr(Auth::user()->name ?? 'P', 0, 1)) }}
                        </div>
                    </div>
                </div>
            </nav>

            <main class="flex-1 overflow-y-auto p-4 sm:p-6">
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
        </div>
    </div>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({ once: true, offset: 50, duration: 600 });

        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            const isOpen = !sidebar.classList.contains('-translate-x-full');

            if (isOpen) {
                sidebar.classList.add('-translate-x-full');
                overlay.classList.add('hidden');
            } else {
                sidebar.classList.remove('-translate-x-full');
                overlay.classList.remove('hidden');
            }
        }

        window.addEventListener('resize', function() {
            if (window.innerWidth >= 1024) {
                document.getElementById('sidebar').classList.remove('-translate-x-full');
                document.getElementById('sidebarOverlay').classList.add('hidden');
            }
        });

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                const sidebar = document.getElementById('sidebar');
                if (!sidebar.classList.contains('-translate-x-full')) {
                    toggleSidebar();
                }
            }
        });
    </script>
</body>
</html>