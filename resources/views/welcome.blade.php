<!DOCTYPE html>
<html lang="en" x-data="theme()" :class="(dark ? 'dark ' : '') + currentPreset">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CovidCare — Vaccination Management System</title>
    @vite('resources/css/app.css')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.8/dist/cdn.min.js"></script>
    <style>
        :root {
            --primary: #4f46e5;
            --primary-dark: #4338ca;
            --primary-light: #818cf8;
            --primary-bg: #eef2ff;
            --primary-bg-dark: #1e1b4b;
            --accent: #3b82f6;
            --accent-dark: #2563eb;
            --accent-light: #93c5fd;
            --accent-bg: #eff6ff;
            --bg: #ffffff;
            --bg-alt: #f9fafb;
            --card: #ffffff;
            --card-hover: #ffffff;
            --text: #111827;
            --text-secondary: #6b7280;
            --text-muted: #9ca3af;
            --border: #e5e7eb;
            --shadow: rgba(79, 70, 229, 0.15);
        }

        .dark {
            --primary: #818cf8;
            --primary-dark: #6366f1;
            --primary-light: #a5b4fc;
            --primary-bg: #1e1b4b;
            --primary-bg-dark: #0f0d2e;
            --accent: #60a5fa;
            --accent-dark: #3b82f6;
            --accent-light: #93c5fd;
            --accent-bg: #172554;
            --bg: #030712;
            --bg-alt: #0f172a;
            --card: #111827;
            --card-hover: #1f2937;
            --text: #f3f4f6;
            --text-secondary: #9ca3af;
            --text-muted: #6b7280;
            --border: #1f2937;
            --shadow: rgba(0, 0, 0, 0.5);
        }

        html {
            scroll-behavior: smooth;
        }

        [x-cloak] {
            display: none !important;
        }

        body {
            background-color: var(--bg);
            color: var(--text);
            transition: background-color .3s, color .3s;
        }

        .theme-primary {
            color: var(--primary);
        }

        .theme-primary-bg {
            background-color: var(--primary);
        }

        .theme-primary-dark-bg {
            background-color: var(--primary-dark);
        }

        .theme-primary-light {
            color: var(--primary-light);
        }

        .theme-primary-tint {
            background-color: var(--primary-bg);
        }

        .theme-primary-border {
            border-color: var(--primary-bg);
        }

        .theme-accent {
            color: var(--accent);
        }

        .theme-accent-bg {
            background-color: var(--accent);
        }

        .theme-accent-tint {
            background-color: var(--accent-bg);
        }

        .theme-text-secondary {
            color: var(--text-secondary);
        }

        .theme-text-muted {
            color: var(--text-muted);
        }

        .theme-border {
            border-color: var(--border);
        }

        .theme-card {
            background-color: var(--card);
            border-color: var(--border);
        }

        .theme-card-hover:hover {
            background-color: var(--card-hover);
        }

        .theme-gradient {
            background: linear-gradient(135deg, var(--primary), var(--accent));
        }

        .theme-gradient-2 {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        }

        .theme-gradient-btn {
            background: linear-gradient(135deg, var(--primary), var(--accent));
        }

        .theme-gradient-btn:hover {
            background: linear-gradient(135deg, var(--primary-dark), var(--accent-dark));
        }

        .theme-gradient-text {
            background: linear-gradient(135deg, var(--primary), var(--accent));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .theme-shadow {
            box-shadow: 0 4px 14px -2px var(--shadow);
        }

        .hover-theme-primary:hover {
            color: var(--primary);
        }

        .dark .dark-hover-theme-primary-light:hover {
            color: var(--primary-light);
        }

        .hover-theme-primary-dark-bg:hover {
            background-color: var(--primary-dark);
        }

        .theme-ring {
            ring-color: var(--primary);
        }

        .theme-btn-primary {
            background: linear-gradient(135deg, var(--primary), var(--accent));
            color: #fff;
        }

        .theme-btn-primary:hover {
            background: linear-gradient(135deg, var(--primary-dark), var(--accent-dark));
        }

        .theme-outline-btn {
            border-color: var(--border);
            color: var(--text-secondary);
        }

        .theme-outline-btn:hover {
            background-color: var(--bg-alt);
        }

        .theme-stats {
            background: linear-gradient(135deg, var(--primary), var(--accent-dark));
        }

        .theme-cta-bg {
            background-color: var(--primary-bg);
            border-color: var(--border);
        }

        .theme-section-alt {
            background-color: var(--bg-alt);
        }

        .theme-section {
            background-color: var(--bg);
        }

        .theme-nav {
            background-color: color-mix(in srgb, var(--bg) 80%, transparent);
            border-color: color-mix(in srgb, var(--border) 80%, transparent);
        }

        .hero-glow {
            position: absolute;
            width: 600px;
            height: 600px;
            border-radius: 50%;
            filter: blur(120px);
            opacity: 0.15;
            pointer-events: none;
        }

        .hero-glow-1 {
            background: var(--primary);
        }

        .hero-glow-2 {
            background: var(--accent);
        }

        .bg-primary-base {
            background-color: var(--primary);
        }

        /* Global overrides — force all common Tailwind classes to use CSS variables */
        .bg-white {
            background-color: var(--bg) !important;
        }

        .bg-gray-50 {
            background-color: var(--bg-alt) !important;
        }

        .text-gray-900,
        .text-gray-800,
        .text-gray-700 {
            color: var(--text) !important;
        }

        .text-gray-600,
        .text-gray-500 {
            color: var(--text-secondary) !important;
        }

        .text-gray-400 {
            color: var(--text-muted) !important;
        }

        .border-gray-100,
        .border-gray-200,
        .border-gray-300 {
            border-color: var(--border) !important;
        }

        .divide-gray-50>*+* {
            border-color: var(--border) !important;
        }

        .dark .dark\:bg-gray-800,
        .dark .dark\:bg-gray-900 {
            background-color: var(--card) !important;
        }

        .dark .dark\:bg-gray-950 {
            background-color: var(--bg) !important;
        }

        .dark .dark\:bg-gray-900\/80 {
            background-color: color-mix(in srgb, var(--bg) 80%, transparent) !important;
        }

        .dark .dark\:bg-gray-800\/50,
        .dark .dark\:bg-gray-700\/50 {
            background-color: color-mix(in srgb, var(--card) 50%, transparent) !important;
        }

        .dark .dark\:hover\:bg-gray-800 {
            background-color: var(--card-hover) !important;
        }

        .dark .dark\:border-gray-600 {
            border-color: var(--border) !important;
        }

        .dark .hover\:bg-white {
            background-color: var(--card) !important;
        }

        .dark .dark\:text-white {
            color: var(--text) !important;
        }

        .dark .dark\:text-gray-300 {
            color: var(--text) !important;
        }

        .dark .dark\:text-gray-100 {
            color: var(--text) !important;
        }

        .dark .dark\:text-gray-400 {
            color: var(--text-secondary) !important;
        }

        .dark .dark\:border-gray-700,
        .dark .dark\:border-gray-800 {
            border-color: var(--border) !important;
        }

        .dark .dark\:shadow-gray-900\/50,
        .dark .dark\:hover\:shadow-gray-900\/50 {
            box-shadow: 0 10px 40px -8px var(--shadow) !important;
        }

        .dark .dark\:ring-offset-gray-900 {
            --tw-ring-offset-color: var(--bg) !important;
        }

        .dark .dark\:shadow-indigo-900\/30 {
            box-shadow: 0 4px 14px -2px var(--shadow) !important;
        }

        /* Override body bg set by Tailwind preflight / body classes */
        body {
            background-color: var(--bg) !important;
            color: var(--text) !important;
        }

        .dev-card::before {
            content: '';
            position: absolute;
            inset: 0;
            border-radius: inherit;
            background: linear-gradient(135deg, transparent 40%, rgba(255, 255, 255, 0.06) 100%);
            pointer-events: none;
        }

        .dev-shape {
            position: absolute;
            border-radius: 50%;
            filter: blur(60px);
            opacity: 0.1;
            pointer-events: none;
        }

        /* Preset theme classes — just add to html element */
        .preset-emerald {
            --primary: #059669;
            --primary-dark: #047857;
            --primary-light: #34d399;
            --primary-bg: #ecfdf5;
            --primary-bg-dark: #022c22;
            --accent: #10b981;
            --accent-dark: #059669;
            --accent-light: #6ee7b7;
            --accent-bg: #f0fdf4;
        }

        .dark.preset-emerald {
            --primary: #34d399;
            --primary-dark: #10b981;
            --primary-light: #6ee7b7;
            --primary-bg: #022c22;
            --primary-bg-dark: #011a11;
            --accent: #6ee7b7;
            --accent-dark: #34d399;
            --accent-light: #a7f3d0;
            --accent-bg: #064e3b;
        }

        .preset-rose {
            --primary: #e11d48;
            --primary-dark: #be123c;
            --primary-light: #fb7185;
            --primary-bg: #fff1f2;
            --primary-bg-dark: #4c0519;
            --accent: #f43f5e;
            --accent-dark: #e11d48;
            --accent-light: #fda4af;
            --accent-bg: #fff1f2;
        }

        .dark.preset-rose {
            --primary: #fb7185;
            --primary-dark: #f43f5e;
            --primary-light: #fda4af;
            --primary-bg: #4c0519;
            --primary-bg-dark: #2d000d;
            --accent: #fda4af;
            --accent-dark: #fb7185;
            --accent-light: #fecdd3;
            --accent-bg: #881337;
        }

        .preset-amber {
            --primary: #d97706;
            --primary-dark: #b45309;
            --primary-light: #fbbf24;
            --primary-bg: #fffbeb;
            --primary-bg-dark: #451a03;
            --accent: #f59e0b;
            --accent-dark: #d97706;
            --accent-light: #fcd34d;
            --accent-bg: #fef3c7;
        }

        .dark.preset-amber {
            --primary: #fbbf24;
            --primary-dark: #f59e0b;
            --primary-light: #fcd34d;
            --primary-bg: #451a03;
            --primary-bg-dark: #2d0d00;
            --accent: #fcd34d;
            --accent-dark: #fbbf24;
            --accent-light: #fde68a;
            --accent-bg: #78350f;
        }

        .preset-violet {
            --primary: #7c3aed;
            --primary-dark: #6d28d9;
            --primary-light: #a78bfa;
            --primary-bg: #f5f3ff;
            --primary-bg-dark: #2e1065;
            --accent: #8b5cf6;
            --accent-dark: #7c3aed;
            --accent-light: #c4b5fd;
            --accent-bg: #ede9fe;
        }

        .dark.preset-violet {
            --primary: #a78bfa;
            --primary-dark: #8b5cf6;
            --primary-light: #c4b5fd;
            --primary-bg: #2e1065;
            --primary-bg-dark: #1a0547;
            --accent: #c4b5fd;
            --accent-dark: #a78bfa;
            --accent-light: #ddd6fe;
            --accent-bg: #4c1d95;
        }

        .preset-cyan {
            --primary: #0891b2;
            --primary-dark: #0e7490;
            --primary-light: #22d3ee;
            --primary-bg: #ecfeff;
            --primary-bg-dark: #083344;
            --accent: #06b6d4;
            --accent-dark: #0891b2;
            --accent-light: #67e8f9;
            --accent-bg: #f0fdfa;
        }

        .dark.preset-cyan {
            --primary: #22d3ee;
            --primary-dark: #06b6d4;
            --primary-light: #67e8f9;
            --primary-bg: #083344;
            --primary-bg-dark: #041e2b;
            --accent: #67e8f9;
            --accent-dark: #22d3ee;
            --accent-light: #a5f3fc;
            --accent-bg: #155e75;
        }
    </style>
</head>

<body
    class="font-sans antialiased bg-white text-gray-900 dark:bg-gray-950 dark:text-gray-100 transition-colors duration-300">

    {{-- NAV --}}
    <nav
        class="fixed top-0 left-0 right-0 z-50 bg-white/80 dark:bg-gray-900/80 backdrop-blur-lg border-b border-gray-100/80 dark:border-gray-800/80">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <a href="#hero"
                    class="flex items-center gap-2 theme-primary dark:theme-primary-light font-bold text-xl tracking-tight">
                    <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                    CovidCare
                </a>
                {{-- Desktop Nav --}}
                <div class="hidden md:flex items-center gap-8">
                    <a href="#features"
                        class="text-sm font-medium text-gray-600 dark:text-gray-400 hover-theme-primary dark-hover-theme-primary-light transition">Features</a>
                    <a href="#roles"
                        class="text-sm font-medium text-gray-600 dark:text-gray-400 hover-theme-primary dark-hover-theme-primary-light transition">For
                        You</a>
                    <a href="#stats"
                        class="text-sm font-medium text-gray-600 dark:text-gray-400 hover-theme-primary dark-hover-theme-primary-light transition">Stats</a>
                    <a href="#contact"
                        class="text-sm font-medium text-gray-600 dark:text-gray-400 hover-theme-primary dark-hover-theme-primary-light transition">Contact</a>
                    <a href="#developers"
                        class="text-sm font-medium text-gray-600 dark:text-gray-400 hover-theme-primary dark-hover-theme-primary-light transition">Developers</a>
                    <button @click="themeOpen = !themeOpen"
                        class="p-2 rounded-xl text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 transition"
                        title="Theme Settings">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        </svg>
                    </button>
                    <div class="h-6 w-px bg-gray-200 dark:bg-gray-700"></div>
                    <button @click="toggleDark()"
                        class="p-2 rounded-xl text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 transition"
                        title="Toggle dark mode">
                        <svg x-show="!dark" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                        </svg>
                        <svg x-show="dark" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </button>
                    <a href="{{ route('patient.login') }}"
                        class="text-sm font-medium text-gray-700 dark:text-gray-300 hover-theme-primary dark-hover-theme-primary-light transition">Sign
                        In</a>
                    <a href="{{ route('patient.register') }}"
                        class="px-5 py-2 theme-gradient-btn text-white text-sm font-semibold rounded-xl hover-theme-primary-dark-bg transition shadow-sm">Get
                        Started</a>
                </div>

                {{-- Mobile Hamburger --}}
                <div class="flex md:hidden items-center gap-1">
                    <button @click="themeOpen = !themeOpen"
                        class="p-2 rounded-xl text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 transition"
                        title="Theme Settings">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        </svg>
                    </button>
                    <button @click="toggleDark()"
                        class="p-2 rounded-xl text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 transition"
                        title="Toggle dark mode">
                        <svg x-show="!dark" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                        </svg>
                        <svg x-show="dark" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </button>
                    <button @click="mobileOpen = !mobileOpen"
                        class="p-2 rounded-xl text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                        <svg x-show="!mobileOpen" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                        <svg x-show="mobileOpen" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    {{-- Mobile Menu --}}
    <div x-show="mobileOpen" x-cloak class="fixed inset-0 z-40 md:hidden"
        x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100">
        <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" @click="mobileOpen = false"></div>
        <div class="absolute top-16 left-0 right-0 bg-white dark:bg-gray-900 border-b border-gray-100 dark:border-gray-800 shadow-xl"
            @click.away="mobileOpen = false" x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 -translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
            <div class="px-4 py-6 space-y-4">
                <a href="#features" @click="mobileOpen = false"
                    class="block px-4 py-2.5 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800 rounded-xl transition">Features</a>
                <a href="#roles" @click="mobileOpen = false"
                    class="block px-4 py-2.5 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800 rounded-xl transition">For
                    You</a>
                <a href="#stats" @click="mobileOpen = false"
                    class="block px-4 py-2.5 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800 rounded-xl transition">Stats</a>
                <a href="#contact" @click="mobileOpen = false"
                    class="block px-4 py-2.5 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800 rounded-xl transition">Contact</a>
                <a href="#developers" @click="mobileOpen = false"
                    class="block px-4 py-2.5 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800 rounded-xl transition">Developers</a>
                <hr class="border-gray-100 dark:border-gray-800">
                <a href="{{ route('patient.login') }}"
                    class="block px-4 py-2.5 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800 rounded-xl transition">Sign
                    In</a>
                <a href="{{ route('patient.register') }}"
                    class="block w-full text-center px-4 py-3 theme-gradient-btn text-white text-sm font-semibold rounded-xl hover-theme-primary-dark-bg transition shadow-sm">Get
                    Started</a>
            </div>
        </div>
    </div>

    {{-- HERO --}}
    <section id="hero"
        class="relative min-h-screen flex items-center overflow-hidden bg-gradient-to-br from-primary-bg/50 to-accent-bg/50 dark:from-gray-900 dark:via-gray-950 dark:to-gray-900 pt-16">
        <div class="hero-glow hero-glow-1 -top-40 -left-40"></div>
        <div class="hero-glow hero-glow-2 -bottom-40 -right-40"></div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 lg:py-32">
            <div class="grid lg:grid-cols-2 gap-12 lg:gap-20 items-center">
                <div data-aos="fade-up" data-aos-duration="800">
                    <div
                        class="inline-flex items-center gap-2 px-4 py-1.5 theme-primary-tint dark:theme-primary-bg theme-primary dark:theme-primary-light text-sm font-medium rounded-full mb-6">
                        <span class="w-2 h-2 bg-primary-base rounded-full animate-pulse"></span>
                        Trusted Healthcare Platform
                    </div>
                    <h1
                        class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-gray-900 dark:text-white leading-tight tracking-tight">
                        Streamlined
                        <span class="text-transparent bg-clip-text theme-gradient-text bg-clip-text">Vaccination</span>
                        &amp; Test Management
                    </h1>
                    <p class="mt-6 text-lg sm:text-xl text-gray-500 dark:text-gray-400 leading-relaxed max-w-xl">
                        Connect patients with hospitals for seamless COVID testing and vaccination appointments.
                        Real-time tracking, instant approvals, and comprehensive reporting.
                    </p>
                    <div class="flex flex-wrap gap-4 mt-8">
                        <a href="{{ route('patient.register') }}"
                            class="px-8 py-3.5 theme-gradient-btn text-white font-semibold rounded-xl hover-theme-primary-dark-bg transition theme-shadow shadow-lg hover:shadow-xl text-sm">
                            Get Started as Patient
                            <svg class="w-4 h-4 inline ml-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                            </svg>
                        </a>
                        <a href="{{ route('hospital.register') }}"
                            class="px-8 py-3.5 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 font-semibold rounded-xl hover:bg-gray-50 dark:hover:bg-gray-800 transition text-sm">
                            Register as Hospital
                        </a>
                    </div>
                    <div class="mt-8 flex items-center gap-6 text-sm text-gray-400 dark:text-gray-500">
                        <span class="flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                            Free to join
                        </span>
                        <span class="flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                            Secure &amp; private
                        </span>
                        <span class="flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                            Real-time updates
                        </span>
                    </div>
                </div>

                <div data-aos="fade-left" data-aos-duration="800" data-aos-delay="200" class="relative">
                    <div
                        class="bg-white dark:bg-gray-800 rounded-3xl shadow-2xl dark:shadow-gray-900/50 border border-gray-100 dark:border-gray-700 p-1">
                        <img src="https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?w=800&q=80"
                            alt="Healthcare" class="rounded-2xl w-full h-auto object-cover">
                    </div>
                    <div class="absolute -bottom-6 -left-6 bg-white dark:bg-gray-800 rounded-2xl shadow-xl dark:shadow-gray-900/50 p-5 flex items-center gap-4"
                        data-aos="fade-up" data-aos-delay="400">
                        <div
                            class="w-12 h-12 bg-emerald-100 dark:bg-emerald-900/50 text-emerald-600 dark:text-emerald-400 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-900 dark:text-white">10k+ Vaccinations</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Processed successfully</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- FEATURES --}}
    <section id="features" class="py-24 bg-white dark:bg-gray-950">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto" data-aos="fade-up">
                <span
                    class="theme-primary dark:theme-primary-light font-semibold text-sm tracking-wider uppercase">Features</span>
                <h2 class="mt-3 text-3xl sm:text-4xl font-bold text-gray-900 dark:text-white">Everything You Need</h2>
                <p class="mt-4 text-gray-500 dark:text-gray-400 text-lg">A complete platform connecting patients,
                    hospitals, and administrators.</p>
            </div>

            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-8 mt-16">
                @php
                    $features = [
                        ['icon' => 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z', 'color' => 'theme-accent-tint theme-accent dark:accent-bg/30 dark:theme-accent-light', 'title' => 'Patient Portal', 'desc' => 'Register, search hospitals, book appointments, and track your test results & vaccination status in real time.'],
                        ['icon' => 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4', 'color' => 'bg-emerald-50 text-emerald-600 dark:bg-emerald-900/30 dark:text-emerald-400', 'title' => 'Hospital Management', 'desc' => 'Approve appointments, update test results, mark vaccinations, and manage your patient queue efficiently.'],
                        ['icon' => 'M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z', 'color' => 'bg-amber-50 text-amber-600 dark:bg-amber-900/30 dark:text-amber-400', 'title' => 'Admin Control', 'desc' => 'Verify hospitals, manage vaccine inventory, view comprehensive reports, and export data to Excel.'],
                        ['icon' => 'M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z', 'color' => 'bg-purple-50 text-purple-600 dark:bg-purple-900/30 dark:text-purple-400', 'title' => 'Smart Search', 'desc' => 'Find approved hospitals by name or location. Browse available healthcare facilities near you.'],
                        ['icon' => 'M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z', 'color' => 'bg-rose-50 text-rose-600 dark:bg-rose-900/30 dark:text-rose-400', 'title' => 'Reports & Analytics', 'desc' => 'Comprehensive reporting with date filtering. Export data to Excel for offline analysis and record-keeping.'],
                        ['icon' => 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z', 'color' => 'bg-cyan-50 text-cyan-600 dark:bg-cyan-900/30 dark:text-cyan-400', 'title' => 'Vaccine Tracking', 'desc' => 'End-to-end vaccination status tracking. Mark patients as vaccinated and maintain digital records.'],
                    ];
                @endphp
                @foreach($features as $i => $f)
                    <div data-aos="fade-up" data-aos-delay="{{ $i * 100 }}"
                        class="group bg-white dark:bg-gray-900 rounded-2xl border border-gray-100 dark:border-gray-800 p-8 hover:shadow-xl dark:hover:shadow-gray-900/50 hover:-translate-y-1 transition-all duration-300">
                        <div
                            class="w-12 h-12 {{ $f['color'] }} rounded-xl flex items-center justify-center mb-5 group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="{{ $f['icon'] }}" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $f['title'] }}</h3>
                        <p class="mt-2 text-gray-500 dark:text-gray-400 text-sm leading-relaxed">{{ $f['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- HOW IT WORKS --}}
    <section class="py-24 bg-gradient-to-b from-gray-50 to-white dark:from-gray-900 dark:to-gray-950">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto" data-aos="fade-up">
                <span class="theme-primary dark:theme-primary-light font-semibold text-sm tracking-wider uppercase">How It Works</span>
                <h2 class="mt-3 text-3xl sm:text-4xl font-bold text-gray-900 dark:text-white">Simple 3-Step Process</h2>
                <p class="mt-4 text-gray-500 dark:text-gray-400 text-lg">Get started with your vaccination or testing journey in minutes.</p>
            </div>

            @php
                $steps = [
                    [
                        'num' => '01',
                        'title' => 'Register Your Account',
                        'desc' => 'Create an account as a patient or hospital. Simple form, instant access.',
                        'color' => 'from-indigo-500 to-blue-600',
                        'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />',
                    ],
                    [
                        'num' => '02',
                        'title' => 'Search & Book',
                        'desc' => 'Patients search for approved hospitals by location and book test or vaccination appointments.',
                        'color' => 'from-emerald-500 to-teal-600',
                        'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />',
                    ],
                    [
                        'num' => '03',
                        'title' => 'Track & Manage',
                        'desc' => 'Hospitals manage requests, update results. Patients track their status in real time.',
                        'color' => 'from-amber-500 to-orange-600',
                        'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />',
                    ],
                ];
            @endphp

            <div class="relative grid md:grid-cols-3 gap-8 mt-16">
                {{-- Connecting line --}}
                <div class="hidden md:block absolute top-16 left-[calc(16.67%+2rem)] right-[calc(16.67%+2rem)] h-0.5 bg-gradient-to-r from-indigo-200 via-emerald-200 to-amber-200 dark:from-indigo-800 dark:via-emerald-800 dark:to-amber-800"></div>

                @foreach($steps as $i => $s)
                    <div data-aos="fade-up" data-aos-delay="{{ $i * 150 }}"
                        class="relative group">
                        {{-- Step number badge --}}
                        <div class="flex justify-center mb-6">
                            <div class="relative">
                                <div class="w-20 h-20 rounded-2xl bg-gradient-to-br {{ $s['color'] }} flex items-center justify-center text-white shadow-xl group-hover:shadow-2xl group-hover:scale-110 transition-all duration-500 relative overflow-hidden">
                                    <div class="absolute inset-0 bg-white/20 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                                    <svg class="w-9 h-9 relative z-10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                        {!! $s['icon'] !!}
                                    </svg>
                                </div>
                                <div class="absolute -top-2 -right-2 w-8 h-8 bg-white dark:bg-gray-900 rounded-full flex items-center justify-center shadow-md border-2 border-gray-100 dark:border-gray-700 font-bold text-sm {{ $s['color'] }} bg-clip-text text-transparent">
                                    {{ $s['num'] }}
                                </div>
                            </div>
                        </div>

                        {{-- Card --}}
                        <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-100 dark:border-gray-800 p-8 shadow-sm group-hover:shadow-xl group-hover:-translate-y-1 transition-all duration-500">
                            {{-- Gradient bar --}}
                            <div class="h-1 w-12 rounded-full bg-gradient-to-r {{ $s['color'] }} mb-5 group-hover:w-full transition-all duration-500"></div>

                            <h3 class="text-xl font-bold text-gray-900 dark:text-white">{{ $s['title'] }}</h3>
                            <p class="mt-3 text-gray-500 dark:text-gray-400 leading-relaxed text-sm">{{ $s['desc'] }}</p>

                            {{-- Step indicator dots --}}
                            <div class="flex gap-1.5 mt-6">
                                @for($d = 0; $d < 3; $d++)
                                    <div class="w-2 h-2 rounded-full {{ $d === $i ? 'opacity-100' : 'opacity-20' }} bg-gradient-to-r {{ $s['color'] }} transition-opacity duration-300"></div>
                                @endfor
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ROLE CARDS --}}
    <section id="roles" class="py-24 bg-white dark:bg-gray-950">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto" data-aos="fade-up">
                <span class="theme-primary dark:theme-primary-light font-semibold text-sm tracking-wider uppercase">For
                    You</span>
                <h2 class="mt-3 text-3xl sm:text-4xl font-bold text-gray-900 dark:text-white">Choose Your Role</h2>
                <p class="mt-4 text-gray-500 dark:text-gray-400 text-lg">Select the portal that matches your needs.</p>
            </div>

            @php
                $roles = [
                    [
                        'name' => 'Patients',
                        'desc' => 'Register, search for approved hospitals, book appointments, and track your test results and vaccination status in real time.',
                        'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />',
                        'features' => ['Free account registration', 'Search hospitals by location', 'Book test or vaccination', 'Track results & status'],
                        'btn_text' => 'Get Started',
                        'btn_link' => route('patient.register'),
                        'accent' => 'var(--accent)',
                        'gradient' => 'var(--primary), var(--accent)',
                        'icon_bg' => 'var(--primary), var(--accent)',
                        'delay' => 0,
                    ],
                    [
                        'name' => 'Hospitals',
                        'desc' => 'Register your facility, manage appointment requests, update patient test results, and mark vaccinations.',
                        'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />',
                        'features' => ['Facility registration', 'Approve or reject requests', 'Update test outcomes', 'Manage vaccination status'],
                        'btn_text' => 'Register Hospital',
                        'btn_link' => route('hospital.register'),
                        'accent' => 'var(--primary)',
                        'gradient' => 'var(--primary-dark), var(--primary)',
                        'icon_bg' => 'var(--primary-dark), var(--primary)',
                        'delay' => 150,
                    ],
                    [
                        'name' => 'Administrators',
                        'desc' => 'Oversee the entire platform, verify hospitals, manage vaccine inventory, and generate reports.',
                        'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />',
                        'features' => ['Hospital verification', 'Vaccine inventory control', 'Comprehensive reports', 'Excel data export'],
                        'btn_text' => 'Admin Login',
                        'btn_link' => route('admin.login'),
                        'accent' => 'var(--accent)',
                        'gradient' => 'var(--accent-dark), var(--accent)',
                        'icon_bg' => 'var(--accent-dark), var(--accent)',
                        'delay' => 300,
                    ],
                ];
            @endphp

            <div class="grid md:grid-cols-3 gap-8 mt-16">
                @foreach($roles as $i => $role)
                    <div data-aos="fade-up" data-aos-delay="{{ $role['delay'] }}"
                        style="--card-accent: {{ $role['accent'] }}; --card-gradient: {{ $role['gradient'] }}; --card-icon-bg: {{ $role['icon_bg'] }};"
                        class="group relative rounded-2xl border border-gray-100 dark:border-gray-800 p-8 transition-all duration-500 hover:shadow-2xl hover:-translate-y-2 bg-white dark:bg-gray-900 hover:bg-gray-50 dark:hover:bg-gray-800/80"
                        x-data="{ hovered: false }" @mouseenter="hovered = true" @mouseleave="hovered = false">

                        {{-- Top gradient accent bar --}}
                        <div class="absolute top-0 left-8 right-8 h-1 rounded-full bg-gradient-to-r opacity-0 group-hover:opacity-100 transition-opacity duration-500"
                            style="background: linear-gradient(to right, var(--card-gradient));"></div>

                        {{-- Icon --}}
                        <div class="w-16 h-16 rounded-2xl flex items-center justify-center text-white shadow-lg mb-6 group-hover:scale-110 group-hover:rotate-3 transition-all duration-500 relative overflow-hidden"
                            style="background: linear-gradient(135deg, var(--card-icon-bg));">
                            <div
                                class="absolute inset-0 bg-white/20 opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                            </div>
                            <svg class="w-8 h-8 relative z-10" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                stroke-width="1.5">
                                {!! $role['icon'] !!}
                            </svg>
                        </div>

                        {{-- Content --}}
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $role['name'] }}</h3>
                        <p class="mt-3 leading-relaxed text-gray-500 dark:text-gray-400">{{ $role['desc'] }}</p>

                        {{-- Feature list --}}
                        <div class="mt-6 space-y-2.5">
                            @foreach($role['features'] as $f)
                                <div class="flex items-center gap-2.5 text-sm text-gray-600 dark:text-gray-300">
                                    <svg class="w-4 h-4 shrink-0 transition-transform duration-300"
                                        :class="hovered ? 'scale-110' : ''" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor" stroke-width="2.5" style="color: var(--card-accent);">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                    </svg>
                                    {{ $f }}
                                </div>
                            @endforeach
                        </div>

                        {{-- Button --}}
                        <a href="{{ $role['btn_link'] }}"
                            class="mt-8 w-full inline-flex items-center justify-center gap-2 px-6 py-3.5 text-white font-semibold rounded-xl transition-all duration-300 shadow-md hover:shadow-xl text-sm relative overflow-hidden group/btn"
                            style="background: linear-gradient(135deg, var(--card-gradient));">
                            <span class="relative z-10">{{ $role['btn_text'] }}</span>
                            <svg class="w-4 h-4 relative z-10 group-hover/btn:translate-x-1 transition-transform duration-300"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                            </svg>
                            <div
                                class="absolute inset-0 bg-white/20 translate-x-[-100%] group-hover/btn:translate-x-0 transition-transform duration-500">
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- STATS --}}
    <section id="stats" class="py-24 theme-stats relative overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-10 left-10 w-72 h-72 bg-white rounded-full blur-3xl"></div>
            <div class="absolute bottom-10 right-10 w-96 h-96 bg-white rounded-full blur-3xl"></div>
        </div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
                @php
                    $stats = [
                        ['num' => '5,000+', 'label' => 'Patients Served'],
                        ['num' => '50+', 'label' => 'Hospitals onboard'],
                        ['num' => '10,000+', 'label' => 'Appointments'],
                        ['num' => '99.9%', 'label' => 'Uptime'],
                    ];
                @endphp
                @foreach($stats as $i => $s)
                    <div data-aos="fade-up" data-aos-delay="{{ $i * 100 }}">
                        <div class="text-4xl sm:text-5xl font-extrabold text-white">{{ $s['num'] }}</div>
                        <div class="mt-2 text-white/70 text-sm font-medium">{{ $s['label'] }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- CTA --}}
    <section id="contact" class="py-24 bg-white dark:bg-gray-950">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center" data-aos="fade-up">
            <div class="theme-cta-bg rounded-3xl p-12 sm:p-16 border theme-primary-border dark:border-gray-700">
                <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 dark:text-white">Ready to Get Started?</h2>
                <p class="mt-4 text-lg text-gray-500 dark:text-gray-400 max-w-xl mx-auto">Join thousands of patients and
                    hospitals already using CovidCare for streamlined vaccination management.</p>
                <div class="flex flex-wrap justify-center gap-4 mt-8">
                    <a href="{{ route('patient.register') }}"
                        class="px-8 py-3.5 theme-gradient-btn text-white font-semibold rounded-xl theme-gradient-btn transition shadow-lg text-sm">
                        Create Patient Account
                    </a>
                    <a href="{{ route('hospital.register') }}"
                        class="px-8 py-3.5 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 font-semibold rounded-xl hover:bg-white dark:hover:bg-gray-800 transition text-sm">
                        Register Your Hospital
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- DEVELOPERS --}}
    <!-- DEVELOPERS SECTION -->
    <section id="developers" class="py-24 bg-gray-50 dark:bg-gray-900 relative overflow-hidden">
        <div
            class="dev-shape bg-indigo-500 -top-40 -left-40 w-96 h-96 absolute rounded-full filter blur-60 opacity-10 pointer-events-none">
        </div>
        <div
            class="dev-shape bg-blue-500 -bottom-40 -right-40 w-96 h-96 absolute rounded-full filter blur-60 opacity-10 pointer-events-none">
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
            <!-- Section Header -->
            <div class="text-center max-w-2xl mx-auto" data-aos="fade-up">
                <span
                    class="text-indigo-600 dark:text-indigo-400 font-semibold text-sm tracking-wider uppercase">Team</span>
                <h2 class="mt-3 text-3xl sm:text-4xl font-bold text-gray-900 dark:text-white">Developed By</h2>
                <p class="mt-4 text-gray-500 dark:text-gray-400 text-lg">The talented team behind CovidCare.</p>
            </div>

            <!-- Developer Cards Grid -->
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-6 mt-16">

                <!-- Card 1: Muhammad Owais (with Blue Tick) -->
                <div data-aos="fade-up" data-aos-delay="0"
                    class="group relative bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 p-6 text-center hover:shadow-xl dark:hover:shadow-gray-900/50 hover:-translate-y-2 transition-all duration-300 overflow-hidden ring-2 ring-blue-500 ring-offset-2 dark:ring-offset-gray-900">




                    <!-- Avatar -->
                    <div class="relative w-20 h-20 mx-auto mt-3 mb-4">
                        <div
                            class="w-full h-full rounded-2xl bg-gradient-to-br from-indigo-500 to-blue-600 flex items-center justify-center text-white text-xl font-bold shadow-lg group-hover:scale-110 group-hover:rotate-3 transition-all duration-300">
                            MO
                        </div>

                    </div>
                    <!-- Name with Blue Tick -->
                    <div class="flex items-center justify-center">
                        <h3 class="text-base font-bold text-gray-900 dark:text-white">
                            Muhammad Owais
                        </h3>

                        <div class="ml-2 w-6 h-6 bg-blue-500 rounded-full flex items-center justify-center shadow-lg border-2 border-white dark:border-gray-800 animate-pulse"
                            title="Super Admin & Lead Developer">
                            <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z" />
                            </svg>
                        </div>
                    </div>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Lead Developer & Architect</p>

                    <!-- Badges -->
                    <span
                        class="inline-block mt-3 px-2.5 py-0.5 bg-gradient-to-r from-blue-500 to-blue-600 text-white text-[10px] font-bold rounded-full shadow-sm">Super
                        Admin</span>
                    <div class="mt-2 flex items-center justify-center gap-1">

                        <path
                            d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z" />
                        </svg>
                        Verified
                        </span>
                    </div>

                    <!-- Quote -->
                    <p class="text-[11px] text-gray-400 dark:text-gray-500 italic mt-3 leading-relaxed px-2">
                        "Architecting scalable solutions."</p>

                    <!-- Skills -->
                    <div class="flex flex-wrap justify-center gap-1.5 mt-4">
                        <span
                            class="px-2 py-0.5 bg-gray-100 dark:bg-gray-700/50 text-gray-600 dark:text-gray-400 text-[10px] font-medium rounded-md">Laravel</span>
                        <span
                            class="px-2 py-0.5 bg-gray-100 dark:bg-gray-700/50 text-gray-600 dark:text-gray-400 text-[10px] font-medium rounded-md">Vue</span>
                        <span
                            class="px-2 py-0.5 bg-gray-100 dark:bg-gray-700/50 text-gray-600 dark:text-gray-400 text-[10px] font-medium rounded-md">MySQL</span>
                        <span
                            class="px-2 py-0.5 bg-gray-100 dark:bg-gray-700/50 text-gray-600 dark:text-gray-400 text-[10px] font-medium rounded-md">AWS</span>
                    </div>

                    <!-- Social Icons -->
                    <div
                        class="flex items-center justify-center gap-2 mt-4 pt-3 border-t border-gray-100 dark:border-gray-700/50">
                        <a href="#"
                            class="w-7 h-7 rounded-lg bg-gray-100 dark:bg-gray-700/50 flex items-center justify-center text-gray-400 hover:bg-indigo-600 hover:text-white transition-all duration-200 text-xs">
                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z" />
                            </svg>
                        </a>
                        <a href="#"
                            class="w-7 h-7 rounded-lg bg-gray-100 dark:bg-gray-700/50 flex items-center justify-center text-gray-400 hover:bg-blue-600 hover:text-white transition-all duration-200 text-xs">
                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z" />
                            </svg>
                        </a>
                        <a href="#"
                            class="w-7 h-7 rounded-lg bg-gray-100 dark:bg-gray-700/50 flex items-center justify-center text-gray-400 hover:bg-sky-500 hover:text-white transition-all duration-200 text-xs">
                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z" />
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Card 2: Muhammad Hammad -->
                <div data-aos="fade-up" data-aos-delay="100"
                    class="group relative bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 p-6 text-center hover:shadow-xl dark:hover:shadow-gray-900/50 hover:-translate-y-2 transition-all duration-300 overflow-hidden">
                    <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-emerald-500 to-teal-600"></div>

                    <div class="relative w-20 h-20 mx-auto mt-3 mb-4">
                        <div
                            class="w-full h-full rounded-2xl bg-gradient-to-br from-emerald-500 to-teal-600 flex items-center justify-center text-white text-xl font-bold shadow-lg group-hover:scale-110 group-hover:rotate-3 transition-all duration-300">
                            MH
                        </div>
                    </div>

                    <h3 class="text-base font-bold text-gray-900 dark:text-white">Muhammad Hammad</h3>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Full Stack Developer</p>

                    <p class="text-[11px] text-gray-400 dark:text-gray-500 italic mt-3 leading-relaxed px-2">"Building
                        end-to-end features."</p>

                    <div class="flex flex-wrap justify-center gap-1.5 mt-4">
                        <span
                            class="px-2 py-0.5 bg-gray-100 dark:bg-gray-700/50 text-gray-600 dark:text-gray-400 text-[10px] font-medium rounded-md">React</span>
                        <span
                            class="px-2 py-0.5 bg-gray-100 dark:bg-gray-700/50 text-gray-600 dark:text-gray-400 text-[10px] font-medium rounded-md">Node</span>
                        <span
                            class="px-2 py-0.5 bg-gray-100 dark:bg-gray-700/50 text-gray-600 dark:text-gray-400 text-[10px] font-medium rounded-md">PostgreSQL</span>
                        <span
                            class="px-2 py-0.5 bg-gray-100 dark:bg-gray-700/50 text-gray-600 dark:text-gray-400 text-[10px] font-medium rounded-md">Docker</span>
                    </div>

                    <div
                        class="flex items-center justify-center gap-2 mt-4 pt-3 border-t border-gray-100 dark:border-gray-700/50">
                        <a href="#"
                            class="w-7 h-7 rounded-lg bg-gray-100 dark:bg-gray-700/50 flex items-center justify-center text-gray-400 hover:bg-indigo-600 hover:text-white transition-all duration-200 text-xs">
                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z" />
                            </svg>
                        </a>
                        <a href="#"
                            class="w-7 h-7 rounded-lg bg-gray-100 dark:bg-gray-700/50 flex items-center justify-center text-gray-400 hover:bg-blue-600 hover:text-white transition-all duration-200 text-xs">
                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z" />
                            </svg>
                        </a>
                        <a href="#"
                            class="w-7 h-7 rounded-lg bg-gray-100 dark:bg-gray-700/50 flex items-center justify-center text-gray-400 hover:bg-sky-500 hover:text-white transition-all duration-200 text-xs">
                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z" />
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Card 3: Muhammad Hunain -->
                <div data-aos="fade-up" data-aos-delay="200"
                    class="group relative bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 p-6 text-center hover:shadow-xl dark:hover:shadow-gray-900/50 hover:-translate-y-2 transition-all duration-300 overflow-hidden">
                    <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-amber-500 to-orange-600"></div>

                    <div class="relative w-20 h-20 mx-auto mt-3 mb-4">
                        <div
                            class="w-full h-full rounded-2xl bg-gradient-to-br from-amber-500 to-orange-600 flex items-center justify-center text-white text-xl font-bold shadow-lg group-hover:scale-110 group-hover:rotate-3 transition-all duration-300">
                            MH
                        </div>
                    </div>

                    <h3 class="text-base font-bold text-gray-900 dark:text-white">Muhammad Hunain</h3>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Frontend Developer</p>

                    <p class="text-[11px] text-gray-400 dark:text-gray-500 italic mt-3 leading-relaxed px-2">"Crafting
                        pixel-perfect UIs."</p>

                    <div class="flex flex-wrap justify-center gap-1.5 mt-4">
                        <span
                            class="px-2 py-0.5 bg-gray-100 dark:bg-gray-700/50 text-gray-600 dark:text-gray-400 text-[10px] font-medium rounded-md">Tailwind</span>
                        <span
                            class="px-2 py-0.5 bg-gray-100 dark:bg-gray-700/50 text-gray-600 dark:text-gray-400 text-[10px] font-medium rounded-md">Alpine</span>
                        <span
                            class="px-2 py-0.5 bg-gray-100 dark:bg-gray-700/50 text-gray-600 dark:text-gray-400 text-[10px] font-medium rounded-md">Vite</span>
                        <span
                            class="px-2 py-0.5 bg-gray-100 dark:bg-gray-700/50 text-gray-600 dark:text-gray-400 text-[10px] font-medium rounded-md">Figma</span>
                    </div>

                    <div
                        class="flex items-center justify-center gap-2 mt-4 pt-3 border-t border-gray-100 dark:border-gray-700/50">
                        <a href="#"
                            class="w-7 h-7 rounded-lg bg-gray-100 dark:bg-gray-700/50 flex items-center justify-center text-gray-400 hover:bg-indigo-600 hover:text-white transition-all duration-200 text-xs">
                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z" />
                            </svg>
                        </a>
                        <a href="#"
                            class="w-7 h-7 rounded-lg bg-gray-100 dark:bg-gray-700/50 flex items-center justify-center text-gray-400 hover:bg-blue-600 hover:text-white transition-all duration-200 text-xs">
                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z" />
                            </svg>
                        </a>
                        <a href="#"
                            class="w-7 h-7 rounded-lg bg-gray-100 dark:bg-gray-700/50 flex items-center justify-center text-gray-400 hover:bg-sky-500 hover:text-white transition-all duration-200 text-xs">
                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z" />
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Card 4: Muhammad Hamayl -->
                <div data-aos="fade-up" data-aos-delay="300"
                    class="group relative bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 p-6 text-center hover:shadow-xl dark:hover:shadow-gray-900/50 hover:-translate-y-2 transition-all duration-300 overflow-hidden">
                    <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-purple-500 to-pink-600"></div>

                    <div class="relative w-20 h-20 mx-auto mt-3 mb-4">
                        <div
                            class="w-full h-full rounded-2xl bg-gradient-to-br from-purple-500 to-pink-600 flex items-center justify-center text-white text-xl font-bold shadow-lg group-hover:scale-110 group-hover:rotate-3 transition-all duration-300">
                            MH
                        </div>
                    </div>

                    <h3 class="text-base font-bold text-gray-900 dark:text-white">Muhammad Hamayl</h3>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Backend Developer</p>

                    <p class="text-[11px] text-gray-400 dark:text-gray-500 italic mt-3 leading-relaxed px-2">"Optimizing
                        server-side logic."</p>

                    <div class="flex flex-wrap justify-center gap-1.5 mt-4">
                        <span
                            class="px-2 py-0.5 bg-gray-100 dark:bg-gray-700/50 text-gray-600 dark:text-gray-400 text-[10px] font-medium rounded-md">PHP</span>
                        <span
                            class="px-2 py-0.5 bg-gray-100 dark:bg-gray-700/50 text-gray-600 dark:text-gray-400 text-[10px] font-medium rounded-md">Python</span>
                        <span
                            class="px-2 py-0.5 bg-gray-100 dark:bg-gray-700/50 text-gray-600 dark:text-gray-400 text-[10px] font-medium rounded-md">Redis</span>
                        <span
                            class="px-2 py-0.5 bg-gray-100 dark:bg-gray-700/50 text-gray-600 dark:text-gray-400 text-[10px] font-medium rounded-md">Nginx</span>
                    </div>

                    <div
                        class="flex items-center justify-center gap-2 mt-4 pt-3 border-t border-gray-100 dark:border-gray-700/50">
                        <a href="#"
                            class="w-7 h-7 rounded-lg bg-gray-100 dark:bg-gray-700/50 flex items-center justify-center text-gray-400 hover:bg-indigo-600 hover:text-white transition-all duration-200 text-xs">
                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z" />
                            </svg>
                        </a>
                        <a href="#"
                            class="w-7 h-7 rounded-lg bg-gray-100 dark:bg-gray-700/50 flex items-center justify-center text-gray-400 hover:bg-blue-600 hover:text-white transition-all duration-200 text-xs">
                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z" />
                            </svg>
                        </a>
                        <a href="#"
                            class="w-7 h-7 rounded-lg bg-gray-100 dark:bg-gray-700/50 flex items-center justify-center text-gray-400 hover:bg-sky-500 hover:text-white transition-all duration-200 text-xs">
                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z" />
                            </svg>
                        </a>
                    </div>
                </div>


            </div>
        </div>
    </section>

    {{-- THEME PANEL --}}
    <div x-show="themeOpen" x-cloak class="fixed inset-0 z-[60]" x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
        <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" @click="themeOpen = false"></div>
        <div class="absolute top-0 right-0 h-full w-full max-w-md bg-white dark:bg-gray-900 shadow-2xl border-l border-gray-100 dark:border-gray-800 overflow-y-auto"
            @click.away="themeOpen = false" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="translate-x-0"
            x-transition:leave-end="translate-x-full">
            <div class="p-6">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-lg font-bold text-gray-900 dark:text-white">Theme Settings</h2>
                    <button @click="themeOpen = false"
                        class="p-2 rounded-xl text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                {{-- Presets --}}
                <div class="mb-6">
                    <label class="text-sm font-semibold text-gray-900 dark:text-white block mb-3">Color Presets</label>
                    <div class="grid grid-cols-3 gap-3">
                        <template x-for="p in presets" :key="p.id">
                            <button @click="applyPreset(p.id)"
                                class="relative p-3 rounded-xl border-2 text-center transition"
                                :class="currentPreset === p.id ? 'border-indigo-500 dark:border-indigo-400 ring-2 ring-indigo-200 dark:ring-indigo-800' : 'border-gray-200 dark:border-gray-700 hover:border-gray-300 dark:hover:border-gray-600'">
                                <div class="flex items-center justify-center gap-1 mb-1.5">
                                    <span class="w-4 h-4 rounded-full" :style="'background:'+p.colors[0]"></span>
                                    <span class="w-4 h-4 rounded-full" :style="'background:'+p.colors[1]"></span>
                                </div>
                                <span class="text-[10px] font-medium text-gray-600 dark:text-gray-400"
                                    x-text="p.label"></span>
                            </button>
                        </template>
                    </div>
                </div>

                {{-- Mode Toggle --}}
                <div class="mb-6 p-4 rounded-xl bg-gray-50 dark:bg-gray-800/50">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-semibold text-gray-900 dark:text-white">Appearance</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5"
                                x-text="dark ? 'Dark mode active' : 'Light mode active'"></p>
                        </div>
                        <button @click="toggleDark()"
                            class="relative w-14 h-7 rounded-full transition-colors duration-300"
                            :class="dark ? 'bg-indigo-600' : 'bg-gray-300'">
                            <span
                                class="absolute top-0.5 left-0.5 w-6 h-6 bg-white rounded-full shadow transition-transform duration-300 flex items-center justify-center"
                                :class="dark ? 'translate-x-7' : ''">
                                <svg x-show="!dark" class="w-3.5 h-3.5 text-amber-500" fill="currentColor"
                                    viewBox="0 0 24 24">
                                    <path
                                        d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                                <svg x-show="dark" class="w-3.5 h-3.5 text-indigo-600" fill="currentColor"
                                    viewBox="0 0 24 24">
                                    <path
                                        d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                                </svg>
                            </span>
                        </button>
                    </div>
                </div>

                {{-- Custom Colors --}}
                <div class="mb-6">
                    <label class="text-sm font-semibold text-gray-900 dark:text-white block mb-3">Custom Colors</label>
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="text-xs text-gray-600 dark:text-gray-400">Primary</span>
                            <div class="flex items-center gap-2">
                                <input type="color" x-model="cp" value="#4f46e5"
                                    class="w-8 h-8 rounded-lg cursor-pointer border border-gray-200 dark:border-gray-700 p-0.5">
                                <input type="color" x-model="ca" value="#3b82f6"
                                    class="w-8 h-8 rounded-lg cursor-pointer border border-gray-200 dark:border-gray-700 p-0.5">
                            </div>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-xs text-gray-600 dark:text-gray-400">Light BG</span>
                            <input type="color" x-model="cbg" value="#ffffff"
                                class="w-8 h-8 rounded-lg cursor-pointer border border-gray-200 dark:border-gray-700 p-0.5">
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-xs text-gray-600 dark:text-gray-400">Light Card</span>
                            <input type="color" x-model="cc" value="#ffffff"
                                class="w-8 h-8 rounded-lg cursor-pointer border border-gray-200 dark:border-gray-700 p-0.5">
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-xs text-gray-600 dark:text-gray-400">Dark BG</span>
                            <input type="color" x-model="cdb" value="#030712"
                                class="w-8 h-8 rounded-lg cursor-pointer border border-gray-200 dark:border-gray-700 p-0.5">
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-xs text-gray-600 dark:text-gray-400">Dark Card</span>
                            <input type="color" x-model="cdc" value="#111827"
                                class="w-8 h-8 rounded-lg cursor-pointer border border-gray-200 dark:border-gray-700 p-0.5">
                        </div>
                    </div>
                    <button @click="saveCustom()"
                        class="mt-3 w-full px-4 py-2 text-xs font-semibold text-white rounded-xl theme-gradient-btn transition">
                        Apply Custom Colors
                    </button>
                </div>

                {{-- Reset --}}
                <button @click="resetTheme()"
                    class="w-full px-4 py-2.5 text-xs font-medium text-gray-600 dark:text-gray-400 border border-gray-200 dark:border-gray-700 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-800 transition">
                    Reset to Default
                </button>
            </div>
        </div>
    </div>

    {{-- FOOTER --}}
    <footer class="bg-gray-900 dark:bg-black text-gray-400 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-4 gap-8">
                <div>
                    <div class="flex items-center gap-2 text-white font-bold text-lg mb-4">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                        CovidCare
                    </div>
                    <p class="text-sm leading-relaxed">Streamlined vaccination and test management platform connecting
                        patients with healthcare facilities.</p>
                </div>
                <div>
                    <h4 class="text-white font-semibold text-sm uppercase tracking-wider mb-4">Quick Links</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('patient.login') }}" class="hover:text-white transition">Patient Login</a>
                        </li>
                        <li><a href="{{ route('hospital.login') }}" class="hover:text-white transition">Hospital
                                Login</a></li>
                        <li><a href="{{ route('admin.login') }}" class="hover:text-white transition">Admin Login</a>
                        </li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-white font-semibold text-sm uppercase tracking-wider mb-4">Registration</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('patient.register') }}" class="hover:text-white transition">Register as
                                Patient</a></li>
                        <li><a href="{{ route('hospital.register') }}" class="hover:text-white transition">Register as
                                Hospital</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-white font-semibold text-sm uppercase tracking-wider mb-4">Contact</h4>
                    <ul class="space-y-2 text-sm">
                        <li>support@covidcare.com</li>
                        <li>1-800-COVID-HELP</li>
                        <li>24/7 Support Available</li>
                    </ul>
                </div>
            </div>
            <div class="mt-12 pt-8 border-t border-gray-800 text-center text-sm">
                &copy; {{ date('Y') }} CovidCare System. All rights reserved.
            </div>
        </div>
    </footer>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({ once: true, offset: 100 });

        document.addEventListener('alpine:init', () => {
            Alpine.data('theme', () => ({
                dark: localStorage.getItem('vs_dark') === 'true' || (!localStorage.getItem('vs_dark') && window.matchMedia('(prefers-color-scheme: dark)').matches),
                currentPreset: localStorage.getItem('vs_preset') || 'preset-default',
                themeOpen: false,
                custom: JSON.parse(localStorage.getItem('vs_custom') || 'null'),
                presets: [
                    { id: 'preset-default', label: 'Indigo', colors: ['#4f46e5', '#3b82f6'] },
                    { id: 'preset-emerald', label: 'Emerald', colors: ['#059669', '#10b981'] },
                    { id: 'preset-rose', label: 'Rose', colors: ['#e11d48', '#f43f5e'] },
                    { id: 'preset-amber', label: 'Amber', colors: ['#d97706', '#f59e0b'] },
                    { id: 'preset-violet', label: 'Violet', colors: ['#7c3aed', '#8b5cf6'] },
                    { id: 'preset-cyan', label: 'Cyan', colors: ['#0891b2', '#06b6d4'] },
                ],
                cp: '#4f46e5', ca: '#3b82f6', cbg: '#ffffff', cc: '#ffffff', cdb: '#030712', cdc: '#111827',
                init() {
                    if (this.custom) this.applyCustom();
                },
                applyPreset(id) {
                    this.currentPreset = id;
                    localStorage.setItem('vs_preset', id);
                    localStorage.removeItem('vs_custom');
                    this.custom = null;
                    document.documentElement.className = ((this.dark ? 'dark ' : '') + id);
                },
                toggleDark() {
                    this.dark = !this.dark;
                    localStorage.setItem('vs_dark', this.dark);
                    document.documentElement.className = ((this.dark ? 'dark ' : '') + this.currentPreset);
                },
                applyCustom() {
                    const c = this.custom;
                    if (!c) return;
                    const root = document.documentElement;
                    root.style.setProperty('--primary', c.primary);
                    root.style.setProperty('--primary-dark', c.primaryDark);
                    root.style.setProperty('--primary-light', c.primaryLight);
                    root.style.setProperty('--primary-bg', c.primaryBg);
                    root.style.setProperty('--accent', c.accent);
                    root.style.setProperty('--accent-dark', c.accentDark);
                    root.style.setProperty('--accent-light', c.accentLight);
                    root.style.setProperty('--accent-bg', c.accentBg);
                    root.style.setProperty('--bg', c.bg);
                    root.style.setProperty('--card', c.card);
                    root.style.setProperty('--bg-alt', c.bgAlt);
                    if (c.darkPrimary) {
                        const d = document.documentElement;
                        d.style.setProperty('--dark-primary', c.darkPrimary);
                        d.style.setProperty('--dark-primary-dark', c.darkPrimaryDark);
                        d.style.setProperty('--dark-primary-light', c.darkPrimaryLight);
                        d.style.setProperty('--dark-primary-bg', c.darkPrimaryBg);
                        d.style.setProperty('--dark-accent', c.darkAccent);
                        d.style.setProperty('--dark-bg', c.darkBg);
                        d.style.setProperty('--dark-card', c.darkCard);
                        d.style.setProperty('--dark-bg-alt', c.darkBgAlt);
                    }
                    this.currentPreset = 'preset-custom';
                    localStorage.setItem('vs_custom', JSON.stringify(c));
                    localStorage.setItem('vs_preset', 'preset-custom');
                },
                saveCustom() {
                    const root = document.documentElement;
                    const s = getComputedStyle(root);
                    const c = {
                        primary: this.cp || s.getPropertyValue('--primary').trim() || '#4f46e5',
                        primaryDark: this.cpd || s.getPropertyValue('--primary-dark').trim() || '#4338ca',
                        primaryLight: this.cpl || s.getPropertyValue('--primary-light').trim() || '#818cf8',
                        primaryBg: this.cpb || s.getPropertyValue('--primary-bg').trim() || '#eef2ff',
                        accent: this.ca || s.getPropertyValue('--accent').trim() || '#3b82f6',
                        accentDark: this.cad || s.getPropertyValue('--accent-dark').trim() || '#2563eb',
                        accentLight: this.cal || s.getPropertyValue('--accent-light').trim() || '#93c5fd',
                        accentBg: this.cab || s.getPropertyValue('--accent-bg').trim() || '#eff6ff',
                        bg: this.cbg || s.getPropertyValue('--bg').trim() || '#ffffff',
                        bgAlt: this.cba || s.getPropertyValue('--bg-alt').trim() || '#f9fafb',
                        card: this.cc || s.getPropertyValue('--card').trim() || '#ffffff',
                        darkPrimary: this.cdp || s.getPropertyValue('--primary').trim() || '#818cf8',
                        darkPrimaryDark: this.cdpd || s.getPropertyValue('--primary-dark').trim() || '#6366f1',
                        darkPrimaryLight: this.cdpl || s.getPropertyValue('--primary-light').trim() || '#a5b4fc',
                        darkPrimaryBg: this.cdpb || s.getPropertyValue('--primary-bg').trim() || '#1e1b4b',
                        darkAccent: this.cda || s.getPropertyValue('--accent').trim() || '#60a5fa',
                        darkBg: this.cdb || s.getPropertyValue('--bg').trim() || '#030712',
                        darkBgAlt: this.cdba || s.getPropertyValue('--bg-alt').trim() || '#0f172a',
                        darkCard: this.cdc || s.getPropertyValue('--card').trim() || '#111827',
                    };
                    this.custom = c;
                    this.applyCustom();
                },
                resetTheme() {
                    localStorage.removeItem('vs_preset');
                    localStorage.removeItem('vs_custom');
                    localStorage.removeItem('vs_dark');
                    this.dark = window.matchMedia('(prefers-color-scheme: dark)').matches;
                    this.currentPreset = 'preset-default';
                    this.custom = null;
                    document.documentElement.className = this.dark ? 'dark preset-default' : 'preset-default';
                    document.documentElement.removeAttribute('style');
                }
            }));
        });
    </script>
</body>

</html>