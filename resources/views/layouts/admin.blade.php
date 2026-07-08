<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel - CovidCare')</title>
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
            background: linear-gradient(135deg, rgba(251, 191, 36, 0.15), rgba(245, 158, 11, 0.10));
            border-right: 3px solid #F59E0B;
        }
        .sidebar-item.active .sidebar-icon {
            color: #F59E0B;
        }
        .sidebar-item.active span {
            color: #F59E0B;
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
    </style>
</head>
<body class="font-sans antialiased bg-gray-50 text-gray-900">

    {{-- Mobile Overlay --}}
    <div id="sidebarOverlay" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-40 hidden lg:hidden" onclick="toggleSidebar()"></div>

    <div class="flex h-screen overflow-hidden">
        {{-- Sidebar --}}
        <aside id="sidebar" class="fixed lg:relative z-50 w-72 h-full bg-white border-r border-gray-200 shadow-xl lg:shadow-none flex-shrink-0 -translate-x-full lg:translate-x-0 sidebar-transition overflow-y-auto scrollbar-hide">
            {{-- Sidebar Header --}}
            <div class="sticky top-0 bg-white/95 backdrop-blur-sm z-10 border-b border-gray-100 px-6 py-5">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-amber-500 to-orange-600 flex items-center justify-center shadow-lg shadow-amber-200/50">
                        <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-lg font-extrabold text-gray-900 tracking-tight">Admin Panel</h1>
                        <p class="text-xs text-gray-400">CovidCare System</p>
                    </div>
                </div>
                <button onclick="toggleSidebar()" class="absolute right-4 top-5 lg:hidden p-1.5 hover:bg-gray-100 rounded-lg transition text-gray-400 hover:text-gray-600">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            {{-- Admin Info --}}
            <div class="px-4 py-4 border-b border-gray-100">
                <div class="flex items-center gap-3 px-3 py-2.5 bg-gradient-to-r from-amber-50 to-orange-50 rounded-xl border border-amber-100">
                    <div class="w-9 h-9 rounded-lg bg-gradient-to-br from-amber-500 to-orange-600 flex items-center justify-center text-white text-sm font-bold shadow-sm relative">
                        {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-gray-900 truncate flex items-center gap-1">
                            {{ Auth::user()->name ?? 'Administrator' }}
                            @if(Auth::user()->isSuperAdmin())
                                <span class="inline-flex items-center justify-center w-4 h-4 bg-blue-500 rounded-full shrink-0" title="Verified Super Admin">
                                    <svg class="w-2.5 h-2.5 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg>
                                </span>
                            @endif
                        </p>
                        <p class="text-xs text-gray-400 truncate">
                            @if(Auth::user()->isSuperAdmin()) Super Admin @else Admin @endif
                        </p>
                    </div>
                    <span class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></span>
                </div>
            </div>

            {{-- Navigation --}}
            <nav class="px-3 py-4 space-y-1">
                @php
                    $navItems = [
                        ['route' => 'admin.dashboard', 'icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6', 'label' => 'Dashboard'],
                        ['route' => 'admin.hospitals', 'icon' => 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4', 'label' => 'Hospitals'],
                        ['route' => 'admin.vaccines', 'icon' => 'M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z', 'label' => 'Vaccines'],
                        ['route' => 'admin.reports', 'icon' => 'M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z', 'label' => 'Reports'],
                        ['route' => 'admin.export', 'icon' => 'M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4', 'label' => 'Export Data'],
                    ];
                @endphp
                @foreach($navItems as $item)
                    <a href="{{ route($item['route']) }}" 
                       class="sidebar-item flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium text-gray-600 hover:text-gray-900 hover:bg-gray-50/80 transition-all duration-200 group {{ request()->routeIs($item['route']) ? 'active' : '' }}">
                        <svg class="sidebar-icon w-5 h-5 text-gray-400 group-hover:text-amber-500 transition-colors {{ request()->routeIs($item['route']) ? 'text-amber-500' : '' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="{{ $item['icon'] }}"/>
                        </svg>
                        <span>{{ $item['label'] }}</span>
                        @if(request()->routeIs($item['route']))
                            <span class="ml-auto w-1.5 h-1.5 bg-amber-500 rounded-full"></span>
                        @endif
                    </a>
                @endforeach
            </nav>

            {{-- Sidebar Footer --}}
            <div class="absolute bottom-0 left-0 right-0 p-4 border-t border-gray-100 bg-white/95 backdrop-blur-sm">
                <form action="{{ route('admin.logout') }}" method="POST">
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

        {{-- Main Content --}}
        <div class="flex-1 flex flex-col min-w-0">
            {{-- Top Navbar --}}
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
                            <p class="text-xs text-gray-400 hidden sm:block">@yield('page-subtitle', 'Overview')</p>
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
                                    $adminUser = Auth::user();
                                    $notifCount = $adminUser ? \App\Helpers\NotificationHelper::unreadCount($adminUser) : 0;
                                @endphp
                                @if($notifCount > 0)
                                    <span class="absolute -top-0.5 -right-0.5 w-5 h-5 bg-red-500 text-white text-[10px] font-bold rounded-full flex items-center justify-center">{{ $notifCount > 9 ? '9+' : $notifCount }}</span>
                                @endif
                            </button>
                            <div x-show="open" @click.away="open = false" x-cloak
                                 class="absolute right-0 mt-2 w-80 bg-white rounded-2xl shadow-2xl border border-gray-100 overflow-hidden z-50"
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 scale-95"
                                 x-transition:enter-end="opacity-100 scale-100">
                                <div class="px-4 py-3 border-b border-gray-100 flex items-center justify-between bg-gray-50/50">
                                    <h3 class="text-sm font-bold text-gray-900">Notifications</h3>
                                    @if($notifCount > 0)
                                        <span class="text-xs bg-amber-100 text-amber-700 px-2 py-0.5 rounded-full font-medium">{{ $notifCount }} new</span>
                                    @endif
                                </div>
                                <div class="max-h-72 overflow-y-auto divide-y divide-gray-50">
                                    @php $recentNotifs = $adminUser ? \App\Helpers\NotificationHelper::getRecent($adminUser, 5) : collect(); @endphp
                                    @forelse($recentNotifs as $notif)
                                        <div class="px-4 py-3 hover:bg-gray-50 transition {{ !$notif->is_read ? 'bg-blue-50/30' : '' }}">
                                            <div class="flex items-start gap-3">
                                                <div class="w-7 h-7 rounded-lg flex items-center justify-center shrink-0 mt-0.5
                                                    @if($notif->type === 'hospital_registered') bg-amber-100 text-amber-600
                                                    @elseif(str_contains($notif->type, 'approved')) bg-emerald-100 text-emerald-600
                                                    @elseif(str_contains($notif->type, 'rejected')) bg-red-100 text-red-600
                                                    @elseif(str_contains($notif->type, 'vaccine')) bg-blue-100 text-blue-600
                                                    @else bg-gray-100 text-gray-600 @endif">
                                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                        @if($notif->type === 'hospital_registered')
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                                        @elseif(str_contains($notif->type, 'approved'))
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                        @elseif(str_contains($notif->type, 'rejected'))
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
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
                                @if($recentNotifs->isNotEmpty())
                                    <div class="px-4 py-2.5 border-t border-gray-100 text-center bg-gray-50/30">
                                        <a href="{{ route('admin.dashboard') }}" class="text-xs text-amber-600 hover:text-amber-700 font-medium">View all notifications</a>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-amber-100 to-orange-100 flex items-center justify-center text-amber-700 text-xs font-bold relative">
                            {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
                            @if(Auth::user()->isSuperAdmin())
                                <span class="absolute -bottom-1 -right-1 w-4 h-4 bg-blue-500 rounded-full flex items-center justify-center" title="Verified Super Admin">
                                    <svg class="w-2.5 h-2.5 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg>
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </nav>

            {{-- Page Content --}}
            <main class="flex-1 overflow-y-auto p-4 sm:p-6">
                @if(session('success'))
                    <div class="mb-6 flex items-center gap-3 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl px-5 py-4 shadow-sm animate-fadeIn" role="alert">
                        <svg class="w-5 h-5 text-emerald-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span class="text-sm font-medium">{{ session('success') }}</span>
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-6 flex items-center gap-3 bg-red-50 border border-red-200 text-red-800 rounded-xl px-5 py-4 shadow-sm animate-fadeIn" role="alert">
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

    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fadeIn {
            animation: fadeIn 0.3s ease-out;
        }
    </style>

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

        // Close sidebar on resize to desktop
        window.addEventListener('resize', function() {
            if (window.innerWidth >= 1024) {
                document.getElementById('sidebar').classList.remove('-translate-x-full');
                document.getElementById('sidebarOverlay').classList.add('hidden');
            }
        });

        // Close sidebar on Escape key
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