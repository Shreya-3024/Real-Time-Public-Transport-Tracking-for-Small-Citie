@extends('layouts.app')

@section('title', 'Admin Dashboard - RT-Tracker')

@section('content')
<div class="space-y-8">
    <!-- Header Stats -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="card bg-gradient-to-br from-brand-cyan/20 to-surface-800 border-brand-cyan/20">
            <p class="text-xs font-bold text-brand-cyan uppercase tracking-widest mb-1">Total Active Buses</p>
            <div class="flex items-end gap-2">
                <span class="text-4xl font-black">24</span>
                <span class="text-brand-emerald text-sm font-bold mb-1">+3 today</span>
            </div>
        </div>
        <div class="card bg-gradient-to-br from-brand-indigo/20 to-surface-800 border-brand-indigo/20">
            <p class="text-xs font-bold text-brand-indigo uppercase tracking-widest mb-1">Total Passengers</p>
            <div class="flex items-end gap-2">
                <span class="text-4xl font-black">1.2k</span>
                <span class="text-brand-emerald text-sm font-bold mb-1">Live</span>
            </div>
        </div>
        <div class="card bg-gradient-to-br from-brand-emerald/20 to-surface-800 border-brand-emerald/20">
            <p class="text-xs font-bold text-brand-emerald uppercase tracking-widest mb-1">Active Routes</p>
            <div class="flex items-end gap-2">
                <span class="text-4xl font-black">12</span>
                <span class="text-gray-500 text-sm font-bold mb-1">Steady</span>
            </div>
        </div>
        <div class="card bg-gradient-to-br from-red-500/20 to-surface-800 border-red-500/20">
            <p class="text-xs font-bold text-red-500 uppercase tracking-widest mb-1">System Alerts</p>
            <div class="flex items-end gap-2">
                <span class="text-4xl font-black">0</span>
                <span class="text-gray-500 text-sm font-bold mb-1">All Clear</span>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- System Health / Analytics -->
        <div class="lg:col-span-2 space-y-8">
            <div class="card">
                <div class="flex justify-between items-center mb-8">
                    <h3 class="text-xl font-bold">System Performance</h3>
                    <select class="bg-surface-700 border-none rounded-lg text-xs font-bold p-2 outline-none">
                        <option>Last 24 Hours</option>
                        <option>Last 7 Days</option>
                    </select>
                </div>
                <!-- Chart Placeholder -->
                <div class="h-64 flex items-end gap-4 px-4">
                    @foreach([40, 70, 45, 90, 65, 80, 50, 95, 60, 85, 40, 75] as $height)
                    <div class="flex-grow bg-brand-cyan/20 rounded-t-lg group relative cursor-pointer hover:bg-brand-cyan/40 transition-all" style="height: {{ $height }}%">
                        <div class="absolute -top-10 left-1/2 -translate-x-1/2 bg-brand-cyan text-brand-navy text-[10px] px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity">
                            {{ $height }}%
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="flex justify-between mt-4 text-[10px] text-gray-500 font-bold uppercase tracking-widest">
                    <span>00:00</span>
                    <span>06:00</span>
                    <span>12:00</span>
                    <span>18:00</span>
                    <span>23:59</span>
                </div>
            </div>

            <!-- Management Table -->
            <div class="card overflow-hidden">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-xl font-bold">Live Fleet Status</h3>
                    <button class="text-sm font-bold text-brand-cyan hover:underline">Manage Fleet</button>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="bg-surface-700/50 text-xs font-bold text-gray-400 uppercase tracking-widest">
                            <tr>
                                <th class="p-4">Bus ID</th>
                                <th class="p-4">Driver</th>
                                <th class="p-4">Route</th>
                                <th class="p-4">Status</th>
                                <th class="p-4 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm divide-y divide-surface-700">
                            @foreach([
                                ['id' => '#B-102', 'driver' => 'Amrit Singh', 'route' => 'Model Town', 'status' => 'Active'],
                                ['id' => '#B-105', 'driver' => 'Jaspreet Kaur', 'route' => 'PAP Chowk', 'status' => 'Maintenance'],
                                ['id' => '#B-110', 'driver' => 'Harman Preet', 'route' => 'Rama Mandi', 'status' => 'Active'],
                                ['id' => '#B-112', 'driver' => 'Rajesh Kumar', 'route' => 'LPU Shuttle', 'status' => 'Off Duty'],
                            ] as $bus)
                            <tr class="hover:bg-surface-700/30 transition-colors">
                                <td class="p-4 font-bold">{{ $bus['id'] }}</td>
                                <td class="p-4 text-gray-300">{{ $bus['driver'] }}</td>
                                <td class="p-4 text-gray-300">{{ $bus['route'] }}</td>
                                <td class="p-4">
                                    <span class="px-2 py-1 rounded-full text-[10px] font-bold uppercase {{ 
                                        $bus['status'] == 'Active' ? 'bg-brand-emerald/10 text-brand-emerald' : 
                                        ($bus['status'] == 'Maintenance' ? 'bg-orange-500/10 text-orange-500' : 'bg-gray-500/10 text-gray-500') 
                                    }}">
                                        {{ $bus['status'] }}
                                    </span>
                                </td>
                                <td class="p-4 text-right">
                                    <button class="text-brand-indigo hover:text-brand-indigo/80 font-bold">Details</button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="space-y-8">
            <!-- Quick Actions -->
            <div class="card">
                <h3 class="text-xl font-bold mb-6">Quick Actions</h3>
                <div class="grid grid-cols-2 gap-4">
                    <button class="p-4 bg-surface-700 hover:bg-surface-600 rounded-xl transition-all text-center space-y-2 group">
                        <div class="w-10 h-10 bg-brand-cyan/20 text-brand-cyan rounded-lg flex items-center justify-center mx-auto group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                        </div>
                        <p class="text-xs font-bold">Add Bus</p>
                    </button>
                    <button class="p-4 bg-surface-700 hover:bg-surface-600 rounded-xl transition-all text-center space-y-2 group">
                        <div class="w-10 h-10 bg-brand-indigo/20 text-brand-indigo rounded-lg flex items-center justify-center mx-auto group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                            </svg>
                        </div>
                        <p class="text-xs font-bold">New Driver</p>
                    </button>
                    <button class="p-4 bg-surface-700 hover:bg-surface-600 rounded-xl transition-all text-center space-y-2 group">
                        <div class="w-10 h-10 bg-brand-emerald/20 text-brand-emerald rounded-lg flex items-center justify-center mx-auto group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                            </svg>
                        </div>
                        <p class="text-xs font-bold">Map View</p>
                    </button>
                    <button class="p-4 bg-surface-700 hover:bg-surface-600 rounded-xl transition-all text-center space-y-2 group">
                        <div class="w-10 h-10 bg-orange-500/20 text-orange-500 rounded-lg flex items-center justify-center mx-auto group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 2v-6m-8 13h12a2 2 0 002-2V5a2 2 0 00-2-2H6a2 2 0 00-2 2v14a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <p class="text-xs font-bold">Reports</p>
                    </button>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="card border-brand-cyan/20">
                <h3 class="text-xl font-bold mb-6">Recent Activity</h3>
                <div class="space-y-6">
                    <div class="flex gap-4">
                        <div class="w-2 h-2 rounded-full bg-brand-emerald mt-1.5 shadow-glow-emerald"></div>
                        <div>
                            <p class="text-sm font-bold">Bus #B-102 started Trip</p>
                            <p class="text-xs text-gray-500">2 minutes ago</p>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <div class="w-2 h-2 rounded-full bg-brand-indigo mt-1.5 shadow-glow-indigo"></div>
                        <div>
                            <p class="text-sm font-bold">New Driver registered: Sarah Smith</p>
                            <p class="text-xs text-gray-500">45 minutes ago</p>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <div class="w-2 h-2 rounded-full bg-brand-cyan mt-1.5 shadow-glow-cyan"></div>
                        <div>
                            <p class="text-sm font-bold">Route 15 updated (Jalandhar)</p>
                            <p class="text-xs text-gray-500">2 hours ago</p>
                        </div>
                    </div>
                </div>
                <button class="w-full mt-8 py-3 bg-surface-700 hover:bg-surface-600 rounded-xl text-xs font-bold uppercase tracking-widest transition-all">View System Logs</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Quick Actions
        document.querySelectorAll('.grid.grid-cols-2 button').forEach(btn => {
            btn.addEventListener('click', function() {
                const action = this.querySelector('p').innerText;
                
                if (action === 'Map View') {
                    openModal('Fleet Live Tracking (Jalandhar)', `
                        <div class="space-y-4">
                            <div class="flex justify-between items-center">
                                <div class="flex gap-4">
                                    <span class="flex items-center gap-2 text-brand-emerald"><span class="w-2 h-2 rounded-full bg-brand-emerald"></span> 24 Active</span>
                                    <span class="flex items-center gap-2 text-orange-500"><span class="w-2 h-2 rounded-full bg-orange-500"></span> 5 Maintenance</span>
                                </div>
                            </div>
                            <div id="admin-map" class="w-full h-[500px] rounded-2xl overflow-hidden border border-surface-700"></div>
                            <div class="flex gap-4 items-center justify-between text-sm">
                                <button class="btn-primary py-2 text-xs" onclick="closeModal()">Close Viewer</button>
                            </div>
                        </div>
                    `);
                    
                    // Initialize Map in Modal
                    window.adminMap = null;
                    
                    // Jalandhar Center
                    const jalandharCoords = [31.3260, 75.5762];
                    window.adminMap = L.map('admin-map').setView(jalandharCoords, 14);
                    
                    // Restrict to Jalandhar bounds
                    const jalandharBounds = L.latLngBounds(
                        [31.2800, 75.5200],
                        [31.3700, 75.6300]
                    );
                    window.adminMap.setMaxBounds(jalandharBounds);
                    window.adminMap.setMinZoom(12);
                    window.adminMap.setMaxZoom(18);
                    
                    const tileUrl = 'https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png';
                    L.tileLayer(tileUrl, {
                        attribution: '&copy; OpenStreetMap'
                    }).addTo(window.adminMap);
                    
                    const busIcon = L.divIcon({
                        className: 'custom-div-icon',
                        html: '<div class="w-8 h-8 bg-brand-cyan rounded-lg flex items-center justify-center border-2 border-white shadow-glow-cyan"><svg class="w-5 h-5 text-brand-navy" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg></div>',
                        iconSize: [32, 32]
                    });
                    
                    L.marker(jalandharCoords, {icon: busIcon}).addTo(window.adminMap).bindPopup('Bus #B-102 (Model Town)');
                    L.marker([31.3360, 75.5862], {icon: busIcon}).addTo(window.adminMap).bindPopup('Bus #B-110 (PAP Chowk)');

                } else if (action === 'Add Bus') {
                    openModal('Add New Vehicle', `
                        <form class="space-y-6">
                            <div class="grid grid-cols-2 gap-4">
                                <div class="space-y-2">
                                    <label class="text-xs font-bold uppercase text-gray-500">Bus ID</label>
                                    <input type="text" placeholder="#B-000" class="input-field px-4">
                                </div>
                                <div class="space-y-2">
                                    <label class="text-xs font-bold uppercase text-gray-500">Route</label>
                                    <select class="input-field px-4">
                                        <option>Route 42 - Jalandhar</option>
                                        <option>Route 15 - PAP Chowk</option>
                                    </select>
                                </div>
                            </div>
                            <div class="space-y-2">
                                <label class="text-xs font-bold uppercase text-gray-500">License Plate</label>
                                <input type="text" placeholder="PB-08-XXXX" class="input-field px-4">
                            </div>
                            <div class="flex gap-4 pt-4">
                                <button type="button" class="btn-primary flex-grow py-3 uppercase font-bold tracking-widest" onclick="closeModal()">Register Bus</button>
                                <button type="button" class="glass px-6 rounded-xl transition-colors font-bold" onclick="closeModal()">Cancel</button>
                            </div>
                        </form>
                    `);
                } else if (action === 'New Driver') {
                    openModal('Register New Driver', `
                        <form class="space-y-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-2">
                                    <label class="text-xs font-bold uppercase text-gray-500">Full Name</label>
                                    <input type="text" placeholder="Amrit Singh" class="input-field px-4">
                                </div>
                                <div class="space-y-2">
                                    <label class="text-xs font-bold uppercase text-gray-500">License Number</label>
                                    <input type="text" placeholder="PB-08-2023-XXXX" class="input-field px-4">
                                </div>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-2">
                                    <label class="text-xs font-bold uppercase text-gray-500">Phone Number</label>
                                    <input type="tel" placeholder="+91 98XXX-XXXXX" class="input-field px-4">
                                </div>
                                <div class="space-y-2">
                                    <label class="text-xs font-bold uppercase text-gray-500">Assigned Route</label>
                                    <select class="input-field px-4">
                                        <option>Route 01 - Model Town</option>
                                        <option>Route 05 - PAP Chowk</option>
                                        <option>Route 12 - Rama Mandi</option>
                                    </select>
                                </div>
                            </div>
                            <div class="space-y-2">
                                <label class="text-xs font-bold uppercase text-gray-500">Aadhar / ID Proof</label>
                                <div class="border-2 border-dashed border-surface-700 rounded-2xl p-8 text-center hover:border-brand-indigo transition-colors cursor-pointer group">
                                    <svg class="w-8 h-8 mx-auto mb-2 text-gray-500 group-hover:text-brand-indigo" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-5-8l-3-3m0 0l-3 3m3-3v12" />
                                    </svg>
                                    <p class="text-xs text-gray-500">Click to upload ID documents</p>
                                </div>
                            </div>
                            <div class="flex gap-4 pt-4">
                                <button type="button" class="btn-secondary flex-grow py-3 uppercase font-bold tracking-widest" onclick="closeModal()">Add Driver</button>
                                <button type="button" class="glass px-6 rounded-xl transition-colors font-bold" onclick="closeModal()">Cancel</button>
                            </div>
                        </form>
                    `);
                } else if (action === 'Reports') {
                    openModal('System Reports Overview', `
                        <div class="space-y-8">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div class="p-4 bg-surface-800 rounded-2xl border border-surface-700">
                                    <p class="text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-1">Total Trips</p>
                                    <p class="text-2xl font-black">1,420</p>
                                    <p class="text-xs text-brand-emerald font-bold mt-1">+12% from last week</p>
                                </div>
                                <div class="p-4 bg-surface-800 rounded-2xl border border-surface-700">
                                    <p class="text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-1">Fuel Efficiency</p>
                                    <p class="text-2xl font-black">14.2 km/L</p>
                                    <p class="text-xs text-brand-cyan font-bold mt-1">-2% variance</p>
                                </div>
                                <div class="p-4 bg-surface-800 rounded-2xl border border-surface-700">
                                    <p class="text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-1">On-Time %</p>
                                    <p class="text-2xl font-black">94.8%</p>
                                    <p class="text-xs text-brand-emerald font-bold mt-1">Goal reached</p>
                                </div>
                            </div>
                            
                            <div class="space-y-4">
                                <h5 class="font-bold text-sm uppercase tracking-widest text-gray-400">Recent Generated Reports</h5>
                                <div class="space-y-2">
                                    <div class="flex items-center justify-between p-4 bg-surface-800 rounded-xl hover:bg-surface-700 transition-colors group cursor-pointer">
                                        <div class="flex items-center gap-4">
                                            <div class="w-10 h-10 bg-brand-cyan/10 text-brand-cyan rounded-lg flex items-center justify-center">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 2v-6m-8 13h12a2 2 0 002-2V5a2 2 0 00-2-2H6a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                                </svg>
                                            </div>
                                            <div>
                                                <p class="font-bold text-sm">Monthly Fleet Performance (Jalandhar)</p>
                                                <p class="text-[10px] text-gray-500 uppercase">May 2026 • PDF • 2.4 MB</p>
                                            </div>
                                        </div>
                                        <svg class="w-5 h-5 text-gray-600 group-hover:text-brand-cyan transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-5-8l-3-3m0 0l-3 3m3-3v12" />
                                        </svg>
                                    </div>
                                    <div class="flex items-center justify-between p-4 bg-surface-800 rounded-xl hover:bg-surface-700 transition-colors group cursor-pointer">
                                        <div class="flex items-center gap-4">
                                            <div class="w-10 h-10 bg-brand-indigo/10 text-brand-indigo rounded-lg flex items-center justify-center">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                            </div>
                                            <div>
                                                <p class="font-bold text-sm">Driver Efficiency Audit</p>
                                                <p class="text-[10px] text-gray-500 uppercase">Q2 2026 • XLSX • 1.1 MB</p>
                                            </div>
                                        </div>
                                        <svg class="w-5 h-5 text-gray-600 group-hover:text-brand-indigo transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-5-8l-3-3m0 0l-3 3m3-3v12" />
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            
                            <button class="btn-primary w-full py-4 text-sm font-black uppercase tracking-widest">Generate Custom Report</button>
                        </div>
                    `);
                } else {
                    openModal(action, `
                        <div class="text-center py-12">
                            <div class="w-20 h-20 bg-brand-indigo/20 text-brand-indigo rounded-full flex items-center justify-center mx-auto mb-6">
                                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                            </div>
                            <h4 class="text-2xl font-bold mb-2">Module Coming Soon</h4>
                            <p class="text-gray-400 max-w-sm mx-auto">The ${action} management system is currently under development. Please check back later.</p>
                            <button class="btn-secondary mt-8 px-12" onclick="closeModal()">Understood</button>
                        </div>
                    `);
                }
            });
        });

        // Fleet Table Details buttons
        document.querySelectorAll('table button').forEach(btn => {
            if (btn.innerText === 'Details') {
                btn.addEventListener('click', function() {
                    const row = this.closest('tr');
                    const busId = row.querySelector('td').innerText;
                    openModal('Vehicle Diagnostics', `
                        <div class="space-y-6">
                            <div class="text-center">
                                <div class="w-20 h-20 bg-brand-indigo/20 text-brand-indigo rounded-full flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 2v-6m-8 13h12a2 2 0 002-2V5a2 2 0 00-2-2H6a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <h4 class="text-xl font-bold">${busId} - Diagnostics</h4>
                                <p class="text-sm text-gray-400">Live Telemetry</p>
                            </div>
                            <div class="grid grid-cols-3 gap-4">
                                <div class="p-4 bg-surface-800 rounded-2xl text-center">
                                    <p class="text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-1">Speed</p>
                                    <p class="font-bold">42 km/h</p>
                                </div>
                                <div class="p-4 bg-surface-800 rounded-2xl text-center">
                                    <p class="text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-1">Fuel</p>
                                    <p class="font-bold text-brand-cyan">82%</p>
                                </div>
                                <div class="p-4 bg-surface-800 rounded-2xl text-center">
                                    <p class="text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-1">Status</p>
                                    <p class="font-bold text-brand-emerald">Healthy</p>
                                </div>
                            </div>
                            <button class="btn-primary w-full" onclick="closeModal()">Close</button>
                        </div>
                    `);
                });
            }
        });

        // System Logs button
        document.querySelector('.space-y-8 > .card > button')?.addEventListener('click', function() {
            openModal('System Activity Logs', `
                <div class="space-y-4 max-h-96 overflow-y-auto">
                    <div class="p-3 bg-surface-800 rounded-lg border-l-2 border-brand-emerald">
                        <span class="text-gray-500">[2026-05-21 01:50:12]</span> <span class="text-brand-emerald">INFO:</span> System initialized successfully.
                    </div>
                    <div class="p-3 bg-surface-800 rounded-lg border-l-2 border-brand-indigo">
                        <span class="text-gray-500">[2026-05-21 01:45:10]</span> <span class="text-brand-indigo">INFO:</span> New driver Sarah Smith verified and assigned to Route 15.
                    </div>
                    <div class="p-3 bg-surface-800 rounded-lg border-l-2 border-brand-cyan">
                        <span class="text-gray-500">[2026-05-21 01:12:05]</span> <span class="text-brand-cyan">UPDATE:</span> Route 15 schedule adjusted for Jalandhar peak hours.
                    </div>
                    <div class="p-3 bg-surface-800 rounded-lg border-l-2 border-gray-600">
                        <span class="text-gray-500">[2026-05-20 23:55:00]</span> <span class="text-gray-500">AUTO:</span> Daily backup completed successfully.
                    </div>
                </div>
                <button class="btn-primary w-full mt-6" onclick="closeModal()">Close</button>
            `);
        });
    });
</script>
@endpush
@endsection