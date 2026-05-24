<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>RT-Tracker Jalandhar | Real-Time Transport Tracking</title>
    
    <script>
        if (localStorage.getItem('theme') === 'dark' || (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

    <!-- Styles / Scripts -->
    <link rel="stylesheet" href="{{ asset('build/assets/app-BlBEV0xQ.css') }}">
    <script type="module" src="{{ asset('build/assets/app-UyRVujZY.js') }}"></script>
</head>
<body class="selection:bg-brand-pink/30 antialiased overflow-x-hidden">
    <!-- Hero Section -->
    <div class="relative min-h-screen flex flex-col">
        <!-- Background Elements -->
        <div class="absolute top-0 left-0 w-full h-full overflow-hidden -z-10 pointer-events-none">
            <div class="absolute -top-[10%] -left-[10%] w-[40%] h-[40%] bg-brand-cyan/20 rounded-full blur-[120px] animate-pulse"></div>
            <div class="absolute top-[20%] -right-[10%] w-[30%] h-[30%] bg-brand-indigo/20 rounded-full blur-[100px] animate-pulse delay-700"></div>
            <div class="absolute -bottom-[10%] left-[20%] w-[35%] h-[35%] bg-brand-emerald/10 rounded-full blur-[100px] animate-pulse delay-1000"></div>
        </div>

        <!-- Navbar -->
        <nav class="max-w-7xl mx-auto w-full px-6 py-8 flex justify-between items-center relative z-10">
            <div class="flex items-center gap-2">
                <div class="w-10 h-10 bg-brand-cyan rounded-xl flex items-center justify-center shadow-glow-cyan">
                    <svg class="w-6 h-6 text-brand-navy" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                    </svg>
                </div>
                <span class="text-2xl font-black tracking-tighter bg-gradient-to-r from-brand-cyan to-brand-indigo bg-clip-text text-transparent uppercase">RT-Tracker</span>
            </div>
            
            <div class="flex items-center gap-6">
                <button onclick="toggleTheme()" class="w-10 h-10 rounded-xl glass flex items-center justify-center hover:text-brand-cyan transition-all group" title="Toggle Theme">
                    <svg class="w-5 h-5 hidden dark:block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707m12.728 0l-.707-.707M6.343 6.343l-.707-.707M12 8a4 4 0 100 8 4 4 0 000-8z" />
                    </svg>
                    <svg class="w-5 h-5 block dark:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                    </svg>
                </button>
                <a href="{{ route('login') }}" class="text-sm font-bold hover:text-brand-cyan transition-colors">Log In</a>
                <a href="{{ route('register') }}" class="btn-primary py-2 px-6 text-sm">Sign Up</a>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="flex-grow flex items-center justify-center px-6 relative z-10">
            <div class="max-w-4xl text-center space-y-12">
                <div class="space-y-4">
                    <span class="inline-block px-4 py-1.5 rounded-full bg-brand-cyan/10 border border-brand-cyan/20 text-brand-cyan text-xs font-black uppercase tracking-[0.2em]">Next-Gen Jalandhar City Transport</span>
                    <h1 class="text-6xl md:text-8xl font-black tracking-tighter leading-tight">
                        TRACK JALANDHAR <span class="bg-gradient-to-r from-brand-cyan via-brand-indigo to-brand-emerald bg-clip-text text-transparent">ROADS</span><br>
                        LIVE NOW.
                    </h1>
                    <p class="text-gray-400 text-lg md:text-xl max-w-2xl mx-auto font-medium">
                        The ultimate tracking system for Jalandhar City. From Model Town to PAP Chowk, track your local buses and shuttles in real-time.
                    </p>
                </div>

                <div class="flex flex-col md:flex-row items-center justify-center gap-6">
                    <a href="{{ route('passenger.dashboard') }}" class="group w-full md:w-auto">
                        <div class="card bg-surface-800/50 hover:bg-brand-cyan/10 hover:border-brand-cyan/50 transition-all p-8 flex flex-col items-center gap-4 group-hover:-translate-y-2">
                            <div class="w-16 h-16 rounded-2xl bg-brand-cyan/20 text-brand-cyan flex items-center justify-center">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                                </svg>
                            </div>
                            <div class="text-center">
                                <h3 class="text-xl font-black uppercase tracking-tight">Passenger</h3>
                                <p class="text-sm text-gray-500 font-medium">Track your ride live</p>
                            </div>
                        </div>
                    </a>

                    <a href="{{ route('driver.dashboard') }}" class="group w-full md:w-auto">
                        <div class="card bg-surface-800/50 hover:bg-brand-indigo/10 hover:border-brand-indigo/50 transition-all p-8 flex flex-col items-center gap-4 group-hover:-translate-y-2">
                            <div class="w-16 h-16 rounded-2xl bg-brand-indigo/20 text-brand-indigo flex items-center justify-center">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                            </div>
                            <div class="text-center">
                                <h3 class="text-xl font-black uppercase tracking-tight">Driver</h3>
                                <p class="text-sm text-gray-500 font-medium">Manage your trips</p>
                            </div>
                        </div>
                    </a>

                    <a href="{{ route('admin.dashboard') }}" class="group w-full md:w-auto">
                        <div class="card bg-surface-800/50 hover:bg-brand-emerald/10 hover:border-brand-emerald/50 transition-all p-8 flex flex-col items-center gap-4 group-hover:-translate-y-2">
                            <div class="w-16 h-16 rounded-2xl bg-brand-emerald/20 text-brand-emerald flex items-center justify-center">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                </svg>
                            </div>
                            <div class="text-center">
                                <h3 class="text-xl font-black uppercase tracking-tight">Admin</h3>
                                <p class="text-sm text-gray-500 font-medium">System analytics</p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </main>

        <!-- Footer -->
        <footer class="p-12 text-center relative z-10">
            <div class="flex items-center justify-center gap-4 mb-4">
                <div class="h-px w-12 bg-surface-700"></div>
                <div class="flex gap-4">
                    <div class="w-2 h-2 rounded-full bg-brand-cyan shadow-glow-cyan"></div>
                    <div class="w-2 h-2 rounded-full bg-brand-indigo shadow-glow-indigo"></div>
                    <div class="w-2 h-2 rounded-full bg-brand-emerald shadow-glow-emerald"></div>
                </div>
                <div class="h-px w-12 bg-surface-700"></div>
            </div>
            <p class="text-gray-500 text-sm font-medium uppercase tracking-[0.3em]">Built for the future of transport</p>
        </footer>
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
    </script>
</body>
</html>
