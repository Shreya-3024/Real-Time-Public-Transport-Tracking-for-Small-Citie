@extends('layouts.app')

@section('title', 'Login - RT-Tracker')

@section('content')
<div class="flex items-center justify-center min-h-[60vh]">
    <div class="card w-full max-w-md space-y-8 bg-gradient-to-br from-surface-800 to-surface-900 border-brand-pink/20">
        <div class="text-center">
            <h2 class="text-3xl font-black tracking-tight">Welcome Back</h2>
            <p class="text-gray-400 mt-2">Log in to your RT-Tracker account</p>
        </div>

        <form class="space-y-6" method="POST" action="{{ route('login') }}">
            @csrf
            <div class="space-y-2">
                <label class="text-xs font-bold uppercase tracking-widest text-gray-400">Email Address</label>
                <div class="relative">
                    <input type="email" name="email" placeholder="name@example.com" class="w-full bg-surface-700 border-none rounded-xl py-3 px-12 focus:ring-2 focus:ring-brand-pink outline-none transition-all" required>
                    <svg class="w-5 h-5 absolute left-4 top-3.5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.206" />
                    </svg>
                </div>
                @error('email')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="space-y-2">
                <div class="flex justify-between items-center">
                    <label class="text-xs font-bold uppercase tracking-widest text-gray-400">Password</label>
                </div>
                <div class="relative">
                    <input type="password" name="password" placeholder="••••••••" class="w-full bg-surface-700 border-none rounded-xl py-3 px-12 focus:ring-2 focus:ring-brand-pink outline-none transition-all" required>
                    <svg class="w-5 h-5 absolute left-4 top-3.5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>
            </div>

            <div class="flex items-center gap-2">
                <input type="checkbox" id="remember" name="remember" class="w-4 h-4 rounded border-none bg-surface-700 text-brand-pink focus:ring-brand-pink">
                <label for="remember" class="text-xs text-gray-400 font-medium cursor-pointer">Remember me for 30 days</label>
            </div>

            <button type="submit" class="btn-primary w-full py-4 text-lg font-black uppercase tracking-widest">
                Log In
            </button>
        </form>

        <div class="text-center pt-4 border-t border-surface-700">
            <p class="text-sm text-gray-400">
                Don't have an account? 
                <a href="{{ route('register') }}" class="text-brand-pink font-bold hover:underline">Sign up for free</a>
            </p>
        </div>
    </div>
</div>
@endsection
