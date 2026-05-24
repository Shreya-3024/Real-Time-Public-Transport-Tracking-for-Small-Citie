@extends('layouts.app')

@section('title', 'Register - RT-Tracker')

@section('content')
<div class="flex items-center justify-center min-h-[70vh]">
    <div class="card w-full max-w-lg space-y-8 bg-gradient-to-br from-surface-800 to-surface-900 border-brand-purple/20">
        <div class="text-center">
            <h2 class="text-3xl font-black tracking-tight">Create Account</h2>
            <p class="text-gray-400 mt-2">Join the future of transport tracking</p>
        </div>

        <form class="space-y-6" method="POST" action="{{ route('register') }}">
            @csrf
            <div class="grid grid-cols-1 gap-6">
                <div class="space-y-2">
                    <label class="text-xs font-bold uppercase tracking-widest text-gray-400">Full Name</label>
                    <div class="relative">
                        <input type="text" name="name" placeholder="John Doe" class="w-full bg-surface-700 border-none rounded-xl py-3 px-12 focus:ring-2 focus:ring-brand-purple outline-none transition-all" required>
                        <svg class="w-5 h-5 absolute left-4 top-3.5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    @error('name')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="space-y-2">
                <label class="text-xs font-bold uppercase tracking-widest text-gray-400">Email Address</label>
                <div class="relative">
                    <input type="email" name="email" placeholder="name@example.com" class="w-full bg-surface-700 border-none rounded-xl py-3 px-12 focus:ring-2 focus:ring-brand-purple outline-none transition-all" required>
                    <svg class="w-5 h-5 absolute left-4 top-3.5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </div>
                @error('email')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label class="text-xs font-bold uppercase tracking-widest text-gray-400">Password</label>
                    <div class="relative">
                        <input type="password" name="password" placeholder="••••••••" class="w-full bg-surface-700 border-none rounded-xl py-3 px-12 focus:ring-2 focus:ring-brand-purple outline-none transition-all" required minlength="8">
                        <svg class="w-5 h-5 absolute left-4 top-3.5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    @error('password')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="space-y-2">
                    <label class="text-xs font-bold uppercase tracking-widest text-gray-400">Confirm Password</label>
                    <div class="relative">
                        <input type="password" name="password_confirmation" placeholder="••••••••" class="w-full bg-surface-700 border-none rounded-xl py-3 px-12 focus:ring-2 focus:ring-brand-purple outline-none transition-all" required minlength="8">
                        <svg class="w-5 h-5 absolute left-4 top-3.5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="flex items-start gap-2">
                <input type="checkbox" id="terms" class="mt-1 w-4 h-4 rounded border-none bg-surface-700 text-brand-purple focus:ring-brand-purple">
                <label for="terms" class="text-xs text-gray-400 font-medium cursor-pointer">
                    I agree to the <a href="#" class="text-brand-purple hover:underline">Terms of Service</a> and <a href="#" class="text-brand-purple hover:underline">Privacy Policy</a>
                </label>
            </div>

            <button type="submit" class="btn-secondary w-full py-4 text-lg font-black uppercase tracking-widest shadow-glow-purple">
                Create Account
            </button>
        </form>

        <div class="text-center pt-4 border-t border-surface-700">
            <p class="text-sm text-gray-400">
                Already have an account? 
                <a href="{{ route('login') }}" class="text-brand-purple font-bold hover:underline">Log in here</a>
            </p>
        </div>
    </div>
</div>
@endsection
