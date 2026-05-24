<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'Transport Tracker'))</title>

    <script>
        // Set theme before content loads to avoid flicker
        if (localStorage.getItem('theme') === 'dark' || (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

    <!-- Leaflet Map -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    <!-- Styles / Scripts -->
    <link rel="stylesheet" href="{{ asset('build/assets/app-BlBEV0xQ.css') }}">
    <script type="module" src="{{ asset('build/assets/app-UyRVujZY.js') }}"></script>
    
    @stack('styles')
</head>
<body class="selection:bg-brand-cyan/30">
    <div class="min-h-screen flex flex-col">
        <!-- Navigation -->
        <nav class="sticky top-0 z-50 glass m-4 mb-0">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16 items-center">
                    <!-- Logo -->
                    <div class="flex items-center gap-2">
                        <div class="w-10 h-10 bg-brand-cyan rounded-xl flex items-center justify-center shadow-glow-cyan">
                            <svg class="w-6 h-6 text-brand-navy" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <span class="text-xl font-bold tracking-tight bg-gradient-to-r from-brand-cyan to-brand-indigo bg-clip-text text-transparent">
                            RT-Tracker
                        </span>
                    </div>

                    <!-- Links -->
                    @auth
                        <div class="hidden md:flex items-center gap-8 text-sm uppercase tracking-widest font-black">
                            <a href="{{ route('passenger.dashboard') }}" class="hover:text-brand-cyan transition-colors">Tracking</a>
                            <a href="{{ route('driver.dashboard') }}" class="hover:text-brand-cyan transition-colors">Drivers</a>
                            @if(Auth::user()->role->name === 'admin')
                                <a href="{{ route('admin.dashboard') }}" class="hover:text-brand-cyan transition-colors">Admin</a>
                            @endif
                        </div>
                    @endauth

                    <!-- User Actions -->
                    <div class="flex items-center gap-4">
                        <!-- Theme Toggle -->
                        <button onclick="toggleTheme()" class="w-10 h-10 rounded-xl glass flex items-center justify-center hover:text-brand-cyan transition-all group" title="Toggle Theme">
                            <svg id="theme-icon-sun" class="w-5 h-5 hidden dark:block group-hover:rotate-12 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707m12.728 0l-.707-.707M6.343 6.343l-.707-.707M12 8a4 4 0 100 8 4 4 0 000-8z" />
                            </svg>
                            <svg id="theme-icon-moon" class="w-5 h-5 block dark:hidden group-hover:-rotate-12 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                            </svg>
                        </button>

                        @guest
                            <a href="{{ route('login') }}" class="btn-ghost border-2 border-brand-cyan text-brand-cyan hover:bg-brand-cyan/10">
                                Log In
                            </a>
                            <a href="{{ route('register') }}" class="btn-primary">
                                Sign Up
                            </a>
                        @endguest

                        @auth
                            <button class="w-10 h-10 rounded-xl glass flex items-center justify-center hover:text-brand-cyan transition-all" title="Notifications">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                </svg>
                            </button>
                            <div class="w-10 h-10 rounded-xl bg-brand-indigo text-white flex items-center justify-center font-bold text-sm shadow-glow-indigo">
                                {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                            </div>
                            <form method="POST" action="{{ route('logout') }}" class="inline">
                                @csrf
                                <button type="submit" class="btn-ghost border-2 border-brand-pink text-brand-pink hover:bg-brand-pink/10">
                                    Logout
                                </button>
                            </form>
                        @endauth
                    </div>
                </div>
            </div>
        </nav>

        <!-- Page Content -->
        <main class="flex-grow p-4 md:p-8">
            <div class="max-w-7xl mx-auto">
                @yield('content')
            </div>
        </main>

        <!-- Footer -->
        <footer class="p-8 border-t border-surface-800 text-center text-gray-500 text-sm">
            &copy; {{ date('Y') }} Jalandhar City Transport Tracker. Built with 
            <span class="text-brand-pink">♥</span> using Laravel & Tailwind.
        </footer>
    </div>

    <!-- Reusable Modal Container -->
    <div id="global-modal" class="fixed inset-0 z-[9999] hidden items-center justify-center p-4 md:p-8">
        <div class="absolute inset-0 bg-black/60 backdrop-blur-sm modal-overlay"></div>
        <div class="card w-full max-w-4xl relative z-10 overflow-hidden flex flex-col max-h-[90vh]">
            <div class="flex justify-between items-center p-6 border-b border-surface-800">
                <h3 id="modal-title" class="text-xl font-bold">Modal Title</h3>
                <button onclick="closeModal()" class="w-10 h-10 flex items-center justify-center rounded-xl hover:bg-brand-pink/10 hover:text-brand-pink transition-all">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div id="modal-content" class="p-6 overflow-y-auto flex-grow">
                <!-- Content injected via JS -->
            </div>
        </div>
    </div>

    <script>
        function toggleTheme() {
            const html = document.documentElement;
            if (html.classList.contains('dark')) {
                html.classList.remove('dark');
                localStorage.setItem('theme', 'light');
            } else {
                html.classList.add('dark');
                localStorage.setItem('theme', 'dark');
            }
        }

        function openModal(title, contentHtml) {
            const modal = document.getElementById('global-modal');
            document.getElementById('modal-title').innerText = title;
            document.getElementById('modal-content').innerHTML = contentHtml;
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.style.overflow = 'hidden';
        }

        function closeModal() {
            const modal = document.getElementById('global-modal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.style.overflow = '';
        }

        document.querySelector('.modal-overlay').addEventListener('click', closeModal);
    </script>

    @stack('scripts')
</body>
</html>
