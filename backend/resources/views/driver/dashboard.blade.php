@extends('layouts.app')

@section('title', 'Driver Dashboard - RT-Tracker')

@section('content')
<div class="space-y-8">
    <!-- Driver Status & Trip Control -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 space-y-8">
            <!-- Active Trip Card -->
            <div class="card bg-gradient-to-br from-surface-800 to-surface-900 border-l-4 border-l-brand-green">
                <div class="flex justify-between items-start mb-6">
                    <div>
                        <h2 class="text-3xl font-bold">Trip #TR-9821</h2>
                        <p class="text-brand-green font-medium mt-1 tracking-wider uppercase text-sm">On Duty • Active Route</p>
                    </div>
                    <div class="px-4 py-2 bg-brand-green/20 text-brand-green rounded-full text-sm font-bold animate-pulse">
                        LIVE TRACKING
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                    <div class="space-y-4">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-xl bg-surface-700 flex items-center justify-center">
                                <svg class="w-6 h-6 text-brand-pink" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400 font-bold uppercase tracking-widest">Next Stop</p>
                                <p class="text-xl font-bold">PAP Chowk (Main Gate)</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-xl bg-surface-700 flex items-center justify-center">
                                <svg class="w-6 h-6 text-brand-purple" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400 font-bold uppercase tracking-widest">ETA</p>
                                <p class="text-xl font-bold">01:15 PM (5 mins)</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-surface-700/50 rounded-2xl p-6 flex flex-col justify-center text-center">
                        <p class="text-xs text-gray-400 font-bold uppercase tracking-widest mb-2">Current Speed</p>
                        <p class="text-5xl font-black text-white italic">35 <span class="text-lg font-normal not-italic text-gray-400">km/h</span></p>
                    </div>
                </div>

                <div class="flex flex-wrap gap-4">
                    <button class="btn-primary flex-grow md:flex-grow-0 flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 9v6m4-6v6m7-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Pause Trip
                    </button>
                    <button class="bg-red-500 hover:bg-red-600 text-white px-8 py-2.5 rounded-lg transition-all font-bold flex-grow md:flex-grow-0 flex items-center justify-center gap-2 shadow-lg shadow-red-500/30">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        End Trip
                    </button>
                    <button class="btn-secondary flex-grow md:flex-grow-0 flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />
                        </svg>
                        Announce Stop
                    </button>
                </div>
            </div>

            <!-- Route Map / Timeline -->
            <div class="card overflow-hidden">
                <h3 class="text-xl font-bold mb-6">Jalandhar Route Progress</h3>
                <div class="relative pl-8 space-y-12 before:content-[''] before:absolute before:left-[15px] before:top-2 before:bottom-2 before:w-0.5 before:bg-gradient-to-b before:from-brand-pink before:to-brand-purple">
                    @foreach(['PAP Chowk' => 'Passed 12:30 PM', 'Mission Chowk' => 'Passed 12:40 PM', 'Model Town Market' => 'Upcoming', 'Bus Stand' => 'Upcoming'] as $stop => $status)
                    <div class="relative">
                        <div class="absolute -left-[23px] top-1 w-4 h-4 rounded-full border-4 border-surface-800 {{ $status == 'Upcoming' ? 'bg-surface-600' : 'bg-brand-pink' }}"></div>
                        <div>
                            <p class="font-bold {{ $status == 'Upcoming' ? 'text-gray-400' : 'text-white' }}">{{ $stop }}</p>
                            <p class="text-xs {{ $status == 'Upcoming' ? 'text-gray-600' : 'text-brand-pink' }} font-medium">{{ $status }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="space-y-8">
            <!-- Emergency Alert -->
            <div class="card border-2 border-red-500/30 bg-red-500/5 group">
                <h3 class="text-xl font-bold text-red-500 mb-4 flex items-center gap-2">
                    <svg class="w-6 h-6 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    Emergency Protocol
                </h3>
                <p class="text-sm text-gray-400 mb-6">Pressing this button will notify emergency services and the admin panel immediately with your GPS coordinates.</p>
                <button class="w-full py-6 bg-red-600 hover:bg-red-700 text-white rounded-2xl font-black text-xl shadow-xl shadow-red-900/50 transition-all hover:scale-[1.02] active:scale-95 group">
                    <span class="group-hover:animate-pulse">PANIC BUTTON</span>
                </button>
            </div>

            <!-- Vehicle Stats -->
            <div class="card border-brand-purple/20">
                <h3 class="text-xl font-bold mb-6">Vehicle Health</h3>
                <div class="space-y-6">
                    <div class="space-y-2">
                        <div class="flex justify-between text-sm font-bold">
                            <span class="text-gray-400">Fuel Level</span>
                            <span class="text-brand-pink">78%</span>
                        </div>
                        <div class="h-2 w-full bg-surface-700 rounded-full overflow-hidden">
                            <div class="h-full bg-brand-pink" style="width: 78%"></div>
                        </div>
                    </div>
                    <div class="space-y-2">
                        <div class="flex justify-between text-sm font-bold">
                            <span class="text-gray-400">Tire Pressure</span>
                            <span class="text-brand-green">Optimal</span>
                        </div>
                        <div class="h-2 w-full bg-surface-700 rounded-full overflow-hidden">
                            <div class="h-full bg-brand-green" style="width: 100%"></div>
                        </div>
                    </div>
                    <div class="pt-4 border-t border-surface-700">
                        <div class="flex justify-between items-center">
                            <p class="text-xs text-gray-400 font-bold uppercase tracking-widest">Next Maintenance</p>
                            <p class="text-sm font-bold">1,240 km</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Status tracking
        let isTripActive = true;

        const panicBtn = document.querySelector('button.bg-red-600');
        const endTripBtn = document.querySelector('button.bg-red-500');
        const pauseTripBtn = document.querySelector('.btn-primary');
        const announceBtn = document.querySelector('.btn-secondary');

        panicBtn.addEventListener('click', function() {
            openModal('Emergency Protocol', `
                <div class="text-center py-6 space-y-6">
                    <div class="w-20 h-20 bg-red-500/20 text-red-500 rounded-full flex items-center justify-center mx-auto animate-pulse">
                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    <div>
                        <h4 class="text-2xl font-black text-red-500 uppercase tracking-tighter">Confirm Emergency?</h4>
                        <p class="text-gray-400 mt-2">This will notify all emergency services and the admin panel immediately with your location.</p>
                    </div>
                    <div class="flex gap-4">
                        <button class="flex-grow py-4 bg-red-600 hover:bg-red-700 text-white rounded-xl font-black uppercase tracking-widest transition-all" onclick="triggerPanic(this)">CONFIRM PANIC</button>
                        <button class="px-8 bg-surface-800 hover:bg-surface-700 rounded-xl font-bold transition-all" onclick="closeModal()">CANCEL</button>
                    </div>
                </div>
            `);
        });

        window.triggerPanic = function(btn) {
            btn.innerText = 'SIGNAL SENT...';
            btn.disabled = true;
            setTimeout(() => {
                closeModal();
                const panicBtnOrig = document.querySelector('button.bg-red-600');
                panicBtnOrig.classList.add('animate-ping');
                setTimeout(() => panicBtnOrig.classList.remove('animate-ping'), 5000);
            }, 1500);
        };

        endTripBtn.addEventListener('click', function() {
            openModal('End Trip', `
                <div class="text-center py-6 space-y-6">
                    <div class="w-20 h-20 bg-brand-pink/20 text-brand-pink rounded-full flex items-center justify-center mx-auto">
                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </div>
                    <div>
                        <h4 class="text-2xl font-bold">Finish Trip #TR-9821?</h4>
                        <p class="text-gray-400 mt-2">All trip logs will be saved and your status will be set to 'Off Duty'.</p>
                    </div>
                    <div class="flex gap-4">
                        <button class="flex-grow btn-primary py-4 uppercase font-bold tracking-widest" onclick="location.reload()">Finish & Submit</button>
                        <button class="px-8 bg-surface-800 hover:bg-surface-700 rounded-xl font-bold transition-all" onclick="closeModal()">Back</button>
                    </div>
                </div>
            `);
        });

        pauseTripBtn.addEventListener('click', function() {
            isTripActive = !isTripActive;
            const statusText = document.querySelector('.text-brand-green');
            const badge = document.querySelector('.bg-brand-green\\/20');
            
            if (!isTripActive) {
                this.innerHTML = `
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                    </svg>
                    Resume Trip
                `;
                statusText.innerText = 'On Duty • Paused';
                statusText.classList.replace('text-brand-green', 'text-orange-500');
                badge.innerText = 'TRIP PAUSED';
                badge.classList.replace('bg-brand-green/20', 'bg-orange-500/20');
                badge.classList.replace('text-brand-green', 'text-orange-500');
            } else {
                this.innerHTML = `
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 9v6m4-6v6m7-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Pause Trip
                `;
                statusText.innerText = 'On Duty • Active Route';
                statusText.classList.replace('text-orange-500', 'text-brand-green');
                badge.innerText = 'LIVE TRACKING';
                badge.classList.replace('bg-orange-500/20', 'bg-brand-green/20');
                badge.classList.replace('text-orange-500', 'text-brand-green');
            }
        });

        announceBtn.addEventListener('click', function() {
            openModal('Broadcasting Announcement', `
                <div class="text-center py-8 space-y-6">
                    <div class="w-20 h-20 bg-brand-purple/20 text-brand-purple rounded-full flex items-center justify-center mx-auto animate-bounce">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-xl font-bold italic">"Next Stop: PAP Chowk (Jalandhar)"</p>
                        <p class="text-xs text-gray-500 mt-2 uppercase tracking-widest">Broadcasting to all passengers on Jalandhar Bus #102</p>
                    </div>
                    <button class="btn-secondary w-full" onclick="closeModal()">Close</button>
                </div>
            `);
        });
    });
</script>
@endpush
@endsection
