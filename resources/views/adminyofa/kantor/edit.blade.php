@extends('layouts.masteradmin')

@push('plugin-styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
@endpush

@section('content')
@section('content')
<nav class="page-breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/adminyofa">Dashboard</a></li>
    <li class="breadcrumb-item active" aria-current="page">Edit Data Lokasi</li>
  </ol>
</nav>

        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <form method="POST" action="{{ route('kantor.update', $building->building_id) }}">
                            @csrf
                            @method('PUT')

                            <!-- Nama Lokasi -->
                            <div class="mb-3">
                                <label for="name" class="form-label">Nama Lokasi</label>
                                <input type="text" class="form-control" name="name" id="name" value="{{ $building->name }}" required>
                            </div>

                            <!-- Alamat Lokasi -->
                            <div class="mb-3">
                                <label for="address" class="form-label">Alamat Lokasi</label>
                                <textarea class="form-control" name="address" id="address" rows="3" required>{{ $building->address }}</textarea>
                            </div>

                            <!-- Google Map -->
                            <div class="mb-3">
                                <label for="MapLocation" class="form-label">Google Map</label>
                                <div id="MapLocation" style="height: 350px;"></div>
                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" id="Latitude" placeholder="Latitude" name="latitude" value="{{ $building->latitude }}" readonly required>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" id="Longitude" placeholder="Longitude" name="longitude" value="{{ $building->longitude }}" readonly required>
                                    </div>
                                </div>
                            </div>

                            <!-- Radius -->
                            <div class="mb-3">
                                <label for="radius" class="form-label">Radius</label>
                                <input type="number" class="form-control" name="radius" id="radius" value="{{ $building->radius }}" required>
                            </div>

                            <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Simpan</button>
                            <a href="{{ route('adminyofa.kantor.index') }}" class="btn btn-danger"><i class="fa fa-remove"></i> Batal</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>

<!-- Javascript for Map -->
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
<script type="text/javascript">
document.addEventListener('DOMContentLoaded', function () {
    var curLocation = [{{ $building->latitude ?? 0 }}, {{ $building->longitude ?? 0 }}];

    if (curLocation[0] === 0 || curLocation[1] === 0) {
        alert('Koordinat default digunakan. Periksa data lokasi Anda.');
    }

    var map = L.map('MapLocation').setView(curLocation, 15);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    var marker = L.marker(curLocation, {
        draggable: true
    }).addTo(map);

    marker.on('dragend', function(event) {
        var position = marker.getLatLng();
        document.getElementById('Latitude').value = position.lat.toFixed(6);
        document.getElementById('Longitude').value = position.lng.toFixed(6);
    });

    document.getElementById('Latitude').addEventListener('change', function () {
        var lat = parseFloat(this.value);
        var lng = parseFloat(document.getElementById('Longitude').value);
        marker.setLatLng([lat, lng]).update();
        map.setView([lat, lng], 15);
    });

    document.getElementById('Longitude').addEventListener('change', function () {
        var lat = parseFloat(document.getElementById('Latitude').value);
        var lng = parseFloat(this.value);
        marker.setLatLng([lat, lng]).update();
        map.setView([lat, lng], 15);
    });
});
</script>
@endsection
