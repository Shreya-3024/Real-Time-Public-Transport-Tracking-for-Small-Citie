@extends('layouts.app')

@section('title', 'Passenger Dashboard - RT-Tracker')

@section('content')
<div class="space-y-8">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            <div class="card bg-gradient-to-br from-surface-800 to-surface-900 border-brand-cyan/20">
                <h2 class="text-2xl font-bold mb-4 flex items-center gap-2">
                    <span class="w-2 h-8 bg-brand-cyan rounded-full"></span>
                    Jalandhar City Explorer
                </h2>
                <div class="flex flex-col gap-4">
                    <div class="flex flex-col md:flex-row gap-4">
                        <div class="flex-grow relative">
                            <input type="text" id="fromInput" placeholder="From Location (e.g., Model Town)" class="input-field">
                            <svg class="w-5 h-5 absolute left-4 top-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            </svg>
                        </div>
                        <div class="flex-grow relative">
                            <input type="text" id="toInput" placeholder="To Location (e.g., PAP Chowk)" class="input-field">
                            <svg class="w-5 h-5 absolute left-4 top-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            </svg>
                        </div>
                    </div>
                    <div class="flex flex-col md:flex-row gap-4">
                        <button id="toggleMyLocationBtn" class="btn-ghost border-2 border-brand-emerald text-brand-emerald hover:bg-brand-emerald/10">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            </svg>
                            <span id="locationBtnText">My Location</span>
                        </button>
                        <button id="searchBtn" class="btn-primary group flex-grow">
                            <span>Find Route</span>
                            <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <div id="passenger-map-container" class="card h-[500px] relative overflow-hidden group p-0">
                <div id="map" class="w-full h-full z-0"></div>
            </div>
        </div>

        <div class="space-y-6">
            <div class="card">
                <h3 class="text-xl font-bold mb-4">Active in Jalandhar</h3>
                <div class="space-y-4">
                    @foreach(['Route 01 - PAP Chowk', 'Route 05 - Model Town', 'Route 12 - Rama Mandi'] as $bus)
                    <div class="flex items-center justify-between p-3 rounded-xl bg-surface-700/50 hover:bg-surface-700 transition-all cursor-pointer border border-transparent hover:border-brand-indigo/30">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-brand-indigo/20 text-brand-indigo rounded-lg flex items-center justify-center font-bold">
                                {{ substr($bus, 6, 2) }}
                            </div>
                            <div>
                                <p class="font-bold text-sm">{{ $bus }}</p>
                                <p class="text-xs text-gray-400">Next stop: 1.2km away</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-brand-emerald text-sm font-bold">Active</p>
                            <p class="text-xs text-gray-400">3 min</p>
                        </div>
                    </div>
                    @endforeach
                </div>
                <button class="w-full mt-6 py-3 text-sm font-bold text-brand-cyan hover:text-brand-cyan/80 transition-colors uppercase tracking-widest">Full Jalandhar Routes</button>
            </div>

            <div class="card border-brand-indigo/20">
                <h3 class="text-xl font-bold mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-brand-indigo" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z" />
                    </svg>
                    Alerts
                </h3>
                <div class="space-y-4">
                    <div class="p-3 rounded-xl bg-brand-cyan/10 border border-brand-cyan/20">
                        <p class="text-sm font-medium">Route 42 Delay</p>
                        <p class="text-xs text-gray-400 mt-1">Due to heavy traffic at PAP Chowk. Estimated delay: 10 mins.</p>
                    </div>
                    <div class="p-3 rounded-xl bg-brand-emerald/10 border border-brand-emerald/20">
                        <p class="text-sm font-medium">New Route Added</p>
                        <p class="text-xs text-gray-400 mt-1">Route 55 now serves the East Medical Center.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const jalandharCoords = [31.3260, 75.5762];
    window.passengerMap = L.map('map', {
        maxZoom: 17,
        minZoom: 13
    }).setView(jalandharCoords, 14);
    
    const strictJalandharBounds = L.latLngBounds(
        [31.295, 75.535],
        [31.355, 75.615]
    );
    window.passengerMap.setMaxBounds(strictJalandharBounds);
    
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(window.passengerMap);
    
    function createIconWithLabel(color, size, svgContent, labelText) {
        return L.divIcon({
            className: '',
            html: `<div style="display:flex;flex-direction:column;align-items:center;">
                    <div style="width:${size}px;height:${size}px;background:${color};border-radius:8px;display:flex;align-items:center;justify-content:center;border:2px solid white;box-shadow:0 4px 12px rgba(0,0,0,0.3);">${svgContent}</div>
                    <div style="margin-top:4px;padding:2px 8px;background:rgba(0,0,0,0.75);color:white;font-size:10px;font-weight:bold;border-radius:4px;white-space:nowrap;">${labelText}</div>
                   </div>`,
            iconSize: [120, size + 35],
            iconAnchor: [60, size + 35]
        });
    }
    
    const busSvg = '<svg style="width:24px;height:24px;color:#020617;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>';
    const railwaySvg = '<svg style="width:24px;height:24px;color:white;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7h8m-8 4h8m-4 4v4m-4-4h8a2 2 0 002-2V7a2 2 0 00-2-2H8a2 2 0 00-2 2v4a2 2 0 002 2z"/></svg>';
    const universitySvg = '<svg style="width:28px;height:28px;color:white;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5z"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/></svg>';
    const busStationSvg = '<svg style="width:24px;height:24px;color:white;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>';
    const landmarkSvg = '<svg style="width:20px;height:20px;color:white;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>';
    
    const myLocationIcon = L.divIcon({
        className: '',
        html: `<div style="display:flex;flex-direction:column;align-items:center;">
                <div style="width:50px;height:50px;background:#10b981;border-radius:50%;display:flex;align-items:center;justify-content:center;border:4px solid white;box-shadow:0 0 20px rgba(16,185,129,0.6);">
                    <div style="width:20px;height:20px;background:white;border-radius:50%;"></div>
                </div>
                <div style="margin-top:4px;padding:2px 8px;background:rgba(16,185,129,0.9);color:white;font-size:10px;font-weight:bold;border-radius:4px;white-space:nowrap;">My Location</div>
               </div>`,
        iconSize: [120, 75],
        iconAnchor: [60, 75]
    });
    
    const busIcon = createIconWithLabel('#22d3ee', 40, busSvg, 'Bus #102');
    const railwayIcon = createIconWithLabel('#dc2626', 44, railwaySvg, 'Railway');
    const universityIcon = createIconWithLabel('#9333ea', 48, universitySvg, 'LPU');
    const busStationIcon = createIconWithLabel('#10b981', 40, busStationSvg, 'Bus Stand');
    
    const locations = [
        { coords: [31.338, 75.555], icon: createIconWithLabel('#10b981', 40, busStationSvg, 'Model Town Stand'), title: 'Bus Stand (Model Town)', desc: 'Satellite Bus Terminal' },
        { coords: [31.332, 75.565], icon: createIconWithLabel('#f59e0b', 36, landmarkSvg, 'Model Town'), title: 'Model Town Market', desc: 'Shopping Area' },
        { coords: [31.328, 75.575], icon: busIcon, title: 'Bus #102', desc: 'Model Town ↔ PAP Chowk' },
        { coords: [31.325, 75.585], icon: createIconWithLabel('#f59e0b', 36, landmarkSvg, 'PAP Chowk'), title: 'PAP Chowk', desc: 'Major Intersection' },
        { coords: [31.322, 75.595], icon: createIconWithLabel('#f59e0b', 36, landmarkSvg, 'GNDU'), title: 'GNDU Campus', desc: 'Educational Hub' },
        { coords: [31.317, 75.578], icon: createIconWithLabel('#dc2626', 44, railwaySvg, 'Jalandhar City'), title: 'Jalandhar City Railway Station', desc: 'Northern Railway' },
        { coords: [31.315, 75.568], icon: createIconWithLabel('#10b981', 40, busStationSvg, 'City Bus Stand'), title: 'Jalandhar City Bus Stand', desc: 'Main Terminal' },
        { coords: [31.310, 75.588], icon: createIconWithLabel('#dc2626', 44, railwaySvg, 'Cantt Station'), title: 'Jalandhar Cantt Railway Station', desc: 'Cantt Area' },
        { coords: [31.305, 75.570], icon: createIconWithLabel('#f59e0b', 36, landmarkSvg, 'Rainak Bazaar'), title: 'Rainak Bazaar', desc: 'Traditional Market' },
        { coords: [31.300, 75.560], icon: createIconWithLabel('#f59e0b', 36, landmarkSvg, 'Ladowali Rd'), title: 'Ladowali Road', desc: 'Commercial Street' },
        { coords: [31.295, 75.578], icon: createIconWithLabel('#f59e0b', 36, landmarkSvg, 'Rama Mandi'), title: 'Rama Mandi', desc: 'Busy Intersection' },
        { coords: [31.285, 75.570], icon: createIconWithLabel('#9333ea', 48, universitySvg, 'LPU'), title: 'LPU University', desc: 'Lovely Professional University' }
    ];
    
    locations.forEach(function(loc) {
        L.marker(loc.coords, {icon: loc.icon})
            .addTo(window.passengerMap)
            .bindPopup('<div style="padding:8px;"><strong style="font-size:16px;">' + loc.title + '</strong><br><span style="color:#666;font-size:12px;">' + loc.desc + '</span></div>');
    });
    
    const routes = [
        [[31.338, 75.555], [31.332, 75.565], [31.328, 75.575], [31.325, 75.585]],
        [[31.317, 75.578], [31.315, 75.568], [31.310, 75.588]]
    ];
    
    routes.forEach(function(route) {
        L.polyline(route, {
            color: '#22d3ee',
            weight: 5,
            opacity: 0.8,
            dashArray: '10, 10'
        }).addTo(window.passengerMap);
    });
    
    let myLocationMarker = null;
    let myLocationEnabled = false;
    let currentRouteLine = null;
    
    function findLocation(text) {
        const searchText = text.toLowerCase().trim();
        for (let i = 0; i < locations.length; i++) {
            const loc = locations[i];
            if (
                loc.title.toLowerCase().includes(searchText) || 
                loc.desc.toLowerCase().includes(searchText)
            ) {
                return loc;
            }
        }
        return null;
    }
    
    document.getElementById('toggleMyLocationBtn').addEventListener('click', function() {
        myLocationEnabled = !myLocationEnabled;
        
        if (myLocationEnabled) {
            const myCoords = [31.3265, 75.5768];
            myLocationMarker = L.marker(myCoords, {icon: myLocationIcon})
                .addTo(window.passengerMap)
                .bindPopup('<div style="padding:8px;"><strong style="font-size:16px;">My Location</strong></div>');
            window.passengerMap.setView(myCoords, 15);
            document.getElementById('locationBtnText').textContent = 'Hide Location';
        } else {
            if (myLocationMarker) {
                window.passengerMap.removeLayer(myLocationMarker);
                myLocationMarker = null;
            }
            if (currentRouteLine) {
                window.passengerMap.removeLayer(currentRouteLine);
                currentRouteLine = null;
            }
            document.getElementById('locationBtnText').textContent = 'My Location';
        }
    });
    
    document.getElementById('searchBtn').addEventListener('click', function() {
        const fromText = document.getElementById('fromInput').value;
        const toText = document.getElementById('toInput').value;
        
        if (!fromText && !toText) {
            window.passengerMap.setView([31.3260, 75.5762], 14);
            if (currentRouteLine) {
                window.passengerMap.removeLayer(currentRouteLine);
                currentRouteLine = null;
            }
            return;
        }
        
        let fromLoc = null;
        let toLoc = null;
        
        if (fromText) {
            fromLoc = findLocation(fromText);
        } else if (myLocationEnabled && myLocationMarker) {
            fromLoc = { coords: myLocationMarker.getLatLng() };
        }
        
        if (toText) {
            toLoc = findLocation(toText);
        }
        
        if (fromLoc && toLoc) {
            const bounds = L.latLngBounds([fromLoc.coords, toLoc.coords]);
            window.passengerMap.fitBounds(bounds, { padding: [50, 50] });
            
            if (currentRouteLine) {
                window.passengerMap.removeLayer(currentRouteLine);
            }
            
            // Clean Google Maps style route: direct line from A to B (with a smooth blue line)
            let routePoints = [];
            routePoints.push(fromLoc.coords);
            routePoints.push(toLoc.coords);
            
            currentRouteLine = L.polyline(routePoints, {
                color: '#3B82F6',
                weight: 7,
                opacity: 0.95
            }).addTo(window.passengerMap);
        } else if (toLoc) {
            window.passengerMap.setView(toLoc.coords, 16);
        } else if (fromLoc) {
            window.passengerMap.setView(fromLoc.coords, 16);
        } else {
            alert('Location not found! Try: Model Town, PAP Chowk, LPU, etc.');
        }
    });
    
    document.getElementById('toInput').addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            document.getElementById('searchBtn').click();
        }
    });
    
    document.getElementById('fromInput').addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            document.getElementById('searchBtn').click();
        }
    });
});
</script>
@endpush
