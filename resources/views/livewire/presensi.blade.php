<div>
    <div class="container mx-auto max-w-lg py-8 px-4">
        @if($schedule)
            <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-white/10 rounded-xl shadow-sm overflow-hidden">
                
                <div class="p-6 border-b border-gray-200 dark:border-white/10 bg-gray-50/50 dark:bg-white/5">
                    <h2 class="text-xl font-bold tracking-tight text-gray-950 dark:text-white">
                        Informasi Pegawai
                    </h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Detail jadwal dan status kehadiran Anda hari ini.</p>
                </div>

                <div class="p-6 space-y-6">
                    <div class="grid grid-cols-1 gap-4 text-sm">
                        <div class="flex justify-between items-center p-3 rounded-lg bg-gray-50 dark:bg-white/5 border border-gray-100 dark:border-white/10">
                            <span class="text-gray-500 dark:text-gray-400">Nama Pegawai</span>
                            <span class="font-semibold text-gray-900 dark:text-white">{{ $schedule->user->name }}</span>
                        </div>
                        
                        <div class="flex justify-between items-center p-3 rounded-lg bg-gray-50 dark:bg-white/5 border border-gray-100 dark:border-white/10">
                            <span class="text-gray-500 dark:text-gray-400">Kantor</span>
                            <span class="font-medium text-gray-900 dark:text-white">{{ $schedule->office->name }}</span>
                        </div>

                        <div class="flex justify-between items-center p-3 rounded-lg bg-gray-50 dark:bg-white/5 border border-gray-100 dark:border-white/10">
                            <span class="text-gray-500 dark:text-gray-400">Shift</span>
                            <div class="text-right">
                                <span class="block font-medium text-gray-900 dark:text-white">{{ $schedule->shift->name }}</span>
                                <span class="text-xs text-gray-500">{{ $schedule->shift->start_time }} - {{ $schedule->shift->end_time }}</span>
                            </div>
                        </div>

                        <div class="flex justify-between items-center p-3 rounded-lg bg-gray-50 dark:bg-white/5 border border-gray-100 dark:border-white/10">
                            <span class="text-gray-500 dark:text-gray-400">Status Kerja</span>
                            @if ($schedule->is_wfa)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-success-100 text-success-700 dark:bg-success-500/10 dark:text-green-400">
                                    WFA (Remote)
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-primary-100 text-primary-700 dark:bg-primary-500/10 dark:text-gray-400">
                                    WFO (Office)
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="p-4 rounded-xl border border-gray-200 dark:border-white/10 bg-white dark:bg-white/5 text-center">
                            <p class="text-xs uppercase tracking-wider text-gray-500 mb-1">Jam Masuk</p>
                            <p class="text-lg font-bold font-mono text-gray-400 dark:text-primary-600">
                                {{ $attendance->start_time ?? '--:--' }}
                            </p>
                        </div>
                        <div class="p-4 rounded-xl border border-gray-200 dark:border-white/10 bg-white dark:bg-white/5 text-center">
                            <p class="text-xs uppercase tracking-wider text-gray-500 mb-1">Jam Keluar</p>
                            <p class="text-lg font-bold font-mono text-gray-400 dark:text-primary-600">
                                {{ $attendance->end_time ?? '--:--' }}
                            </p>
                        </div>
                    </div>

                    <hr class="border-gray-200 dark:border-white/10">

                    <div>
                        <h3 class="text-lg font-bold mb-3 text-gray-950 dark:text-white">Presensi Lokasi</h3>
                        
                        <div 
                            id="map" 
                            class="mb-4 w-full h-48 border border-gray-300 dark:border-white/10 rounded-xl shadow-inner z-0" 
                            wire:ignore
                        ></div>

                        <form method="post" wire:submit='store' enctype="multipart/form-data" class="space-y-3">
                            <button 
                                type="button" 
                                onclick="tagLocation()" 
                                class="w-full inline-flex justify-center items-center px-4 py-2.5 bg-white dark:bg-white/5 border border-gray-300 dark:border-white/10 font-semibold text-sm text-gray-700 dark:text-gray-200 rounded-lg shadow-sm hover:bg-gray-50 dark:hover:bg-white/10 transition-all"
                            >
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                Tag Lokasi Sekarang
                            </button>

                            @if ($insideRadius)
                                <button 
                                    type="submit" 
                                    class="w-full inline-flex justify-center items-center px-4 py-2.5 bg-green-600 hover:bg-green-500 text-white font-bold text-sm rounded-lg shadow-md transition-all focus:ring-2 focus:ring-primary-500 focus:ring-offset-2"
                                >
                                    Submit Presensi Kehadiran
                                </button>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        @else
            <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-white/10 rounded-xl shadow-sm overflow-hidden p-8 text-center">
                <div class="mb-4 inline-flex items-center justify-center w-16 h-16 rounded-full bg-red-100 dark:bg-red-900/30 text-red-600 dark:text-red-400">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                </div>
                <h2 class="text-xl font-bold text-gray-950 dark:text-white mb-2">Jadwal Tidak Ditemukan</h2>
                <p class="text-gray-500 dark:text-gray-400 mb-6">Maaf, Anda belum memiliki jadwal kerja yang ditetapkan untuk hari ini. Silahkan hubungi admin untuk informasi lebih lanjut.</p>
                <a href="{{ url('/admin') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-500 text-white font-semibold rounded-lg transition-colors">
                    Kembali ke Dashboard
                </a>
            </div>
        @endif
    </div>
</div>

@if($schedule)
<script>
    let map;
    let lat;
    let lng;
    let marker;
    let component;
    const isWfa = @json($schedule->is_wfa);
    const office = [{{ $schedule->office->latitude }}, {{ $schedule->office->longitude }}];
    // Multiply by 3 to make the circle 3x wider
    const radius = {{ $schedule->office->radius }} * 3;

    document.addEventListener('livewire:initialized', function () {
        component = @this;
        map = L.map('map').setView([{{ $schedule->office->latitude }}, {{ $schedule->office->longitude }}], 18);
        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map);

        var officeMarker = L.marker([{{ $schedule->office->latitude }}, {{ $schedule->office->longitude }}]).addTo(map);    
        officeMarker.bindPopup("<b>Kantor:</b> {{ $schedule->office->name }}").openPopup();

        var circle = L.circle(office, {
            color: 'red',
            fillColor: '#f03',
            fillOpacity: 0.5,
            radius: radius
        }).addTo(map);
    })

    function tagLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                lat = position.coords.latitude;
                lng = position.coords.longitude;

                if (marker) {
                    map.removeLayer(marker);
                }

                marker = L.marker([lat, lng]).addTo(map);
                marker.bindPopup("<b>Hello world!</b><br>I am {{ $schedule->user->name }}").openPopup();
                map.setView([lat, lng], 18);

                if (isWithinRadius(lat, lng, office, radius)) {
                    component.set('insideRadius', true);
                    component.set('latitude', lat);
                    component.set('longitude', lng);
                    alert('Anda berada di dalam radius kantor!');
                } else {
                    if (isWfa) {
                        component.set('insideRadius', true);
                        component.set('latitude', lat);
                        component.set('longitude', lng);
                        alert('Anda WFA!');
                    } else {
                        alert('Anda tidak berada di dalam radius kantor!');
                    }
                }
            })
        } else {
            alert('Tidak bisa tag location!')
        }
    }

    function isWithinRadius(lat, lng, center, radius) {
        let distance = map.distance([lat, lng], center);
        return distance <= radius;
    }
</script>
@endif