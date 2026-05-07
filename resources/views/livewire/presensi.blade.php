<div>
    <div class="container mx-auto max-w-sm">
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <div class="grid grid-cols-1 md:grid-cols-1 gap-6 mb-6">
                <div>
                    <h2 class="text-2xl font-bold mb-2">Informasi Pegawai</h2>
                    <div class="bg-gray-100 p-4 rounded-lg">
                        @if($schedule)
                            <p><strong>Nama Pegawai: </strong>{{ $schedule->user->name }}</p>
                            <p><strong>Kantor: </strong>{{ $schedule->office->name }}</p>
                            <p><strong>Shift: </strong>{{ $schedule->shift->name }} ({{ $schedule->shift->start_time }} - {{ $schedule->shift->end_time }})</p>
                        @else
                            <p class="text-red-500"><strong>Anda belum memiliki jadwal hari ini.</strong></p>
                        @endif
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
                        <div class="bg-gray-100 p-4 rounded-lg">
                            <h4 class="text-lg font bold mb-2">Jam Masuk</h4>
                        </div>
                        <div class="bg-gray-100 p-4 rounded-lg">
                            <h4 class="text-lg font bold mb-2">Jam Pulang</h4>
                        </div>
                    </div>
                </div>
 
                <div>
                    <h2 class="text-2xl font-bold mb-2">Presensi</h2>
                    
                    <div id="map" class="mb-4 rounded-lg border border-gray-300" style="height: 300px;" wire:ignore></div>
                    <button type="button" onclick="tagLocation()" class="cursor-pointer px-4 py-2 bg-blue-500 text-white rounded transition-all duration-300 hover:bg-blue-600 hover:shadow-lg hover:-translate-y-1 active:scale-95">Tag Location</button>
                    @if ($insideRadius)
                    <button type="submit" class="cursor-pointer px-4 py-2 bg-green-500 text-white rounded transition-all duration-300 hover:bg-green-600 hover:shadow-lg hover:-translate-y-1 active:scale-95">Submit Presensi</button>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@if($schedule)
<script>
    let map;
    let lat;
    let lng;
    let marker;
    let component;
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
                    alert('Anda berada di dalam radius kantor!');
                } else {
                    component.set('insideRadius', false);
                    alert('Anda tidak berada di dalam radius kantor!');
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