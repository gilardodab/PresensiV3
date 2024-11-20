@extends('layouts.masteradmin')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/datatables-net-bs5/dataTables.bootstrap5.css') }}" rel="stylesheet" />
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
@endpush

@section('content')
<nav class="page-breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/adminyofa">Dashboard</a></li>
    <li class="breadcrumb-item active" aria-current="page">Data Kantor</li>
  </ol>
</nav>

<div class="row">
  <div class="col-md-12 grid-margin stretch-card">
    <div class="card">
      @if (request()->route()->getName() == 'kantor.create')
        <div class="card-body">
          <h6 class="card-title">Tambah Data Kantor</h6>
          <form class="add-lokasi" method="POST" action="{{ route('kantor.store') }}">
            @csrf
            <div class="mb-3">
              <label for="name" class="form-label">Nama Lokasi</label>
              <input type="text" class="form-control" name="name" id="name" value="{{ old('name') }}" required>
            </div>

            <div class="mb-3">
              <label for="address" class="form-label">Alamat Lokasi</label>
              <textarea class="form-control" name="address" id="address" rows="3" required>{{ old('address') }}</textarea>
            </div>

            <div class="mb-3">
              <label for="MapLocation" class="form-label">Google Map</label>
              <div id="MapLocation" style="height: 350px;"></div>
              <div class="row mt-3">
                <div class="col-lg-6">
                  <input type="text" class="form-control" id="Latitude" name="latitude" placeholder="Latitude" value="{{ old('latitude') }}" required>
                </div>
                <div class="col-lg-6">
                  <input type="text" class="form-control" id="Longitude" name="longitude" placeholder="Longitude" value="{{ old('longitude') }}" required>
                </div>
              </div>
            </div>

            <div class="mb-3">
              <label for="radius" class="form-label">Radius</label>
              <div class="input-group">
                <input type="number" class="form-control" name="radius" id="radius" value="{{ old('radius') }}" required>
                <span class="input-group-text">M</span>
              </div>
            </div>

            <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Simpan</button>
            <a href="{{ route('adminyofa.kantor.index') }}" class="btn btn-danger"><i class="fa fa-remove"></i> Batal</a>
          </form>
        </div>
      @else
        <div class="card-body">
          <h6 class="card-title">Data Kantor</h6>
          <a href="{{ route('kantor.create') }}" class="btn btn-success mb-3">
            <i class="fa fa-plus"></i> Tambah Baru
          </a>
          <div class="table-responsive">
            <table id="swdatatable" class="table table-bordered">
              <thead>
                <tr>
                  <th>No</th>
                  <th>ID</th>
                  <th>Nama Lokasi</th>
                  <th>Alamat</th>
                  <th>Radius</th>
                  <th>Karyawan</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                @foreach($buildings as $building)
                <tr>
                  <td>{{ $loop->iteration }}</td>
                  <td>{{ $building->building_id }}</td>
                  <td>{{ $building->name }}</td>
                  <td>{{ $building->address }}</td>
                  <td>{{ $building->radius }}</td>
                  <td>{{ \App\Models\Employee::where('building_id', $building->building_id)->count() }}</td>
                  <td>
                    <a href="{{ route('kantor.edit', $building->building_id) }}" class="btn btn-warning btn-xs">
                      <i class="fa fa-pencil-square-o"></i> Ubah
                    </a>
                    <button class="btn btn-danger btn-xs" onclick="confirmDelete('{{ $building->building_id }}')">
                      <i class="fa fa-trash-o"></i> Hapus
                    </button>
                    <form id="delete-form-{{ $building->building_id }}" action="{{ route('kantor.destroy', $building->building_id) }}" method="POST" style="display: none;">
                      @csrf
                      @method('DELETE')
                    </form>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      @endif
    </div>
  </div>
</div>

<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
<script>
  document.addEventListener('DOMContentLoaded', function () {
    if (document.getElementById('MapLocation')) {
      navigator.geolocation.getCurrentPosition(function(location) {
        var latlng = new L.LatLng(location.coords.latitude, location.coords.longitude);
        document.getElementById('Latitude').value = location.coords.latitude;
        document.getElementById('Longitude').value = location.coords.longitude;

        var map = L.map('MapLocation').setView(latlng, 20);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
          attribution: '&copy; '
        }).addTo(map);

        var marker = L.marker(latlng, { draggable: true }).addTo(map);

        marker.on('dragend', function(e) {
          var position = marker.getLatLng();
          document.getElementById('Latitude').value = position.lat;
          document.getElementById('Longitude').value = position.lng;
        });

        document.getElementById('Latitude').addEventListener('change', function() {
          var newLat = parseFloat(this.value);
          var newLng = parseFloat(document.getElementById('Longitude').value);
          var newPosition = [newLat, newLng];
          marker.setLatLng(newPosition).update();
          map.setView(newPosition, 20);
        });

        document.getElementById('Longitude').addEventListener('change', function() {
          var newLat = parseFloat(document.getElementById('Latitude').value);
          var newLng = parseFloat(this.value);
          var newPosition = [newLat, newLng];
          marker.setLatLng(newPosition).update();
          map.setView(newPosition, 20);
        });
      });
    }
  });

  function confirmDelete(id) {
    if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
      document.getElementById('delete-form-' + id).submit();
    }
  }
</script>
@endsection

@push('plugin-scripts')
  <script src="{{ asset('assets/plugins/datatables-net/jquery.dataTables.js') }}"></script>
  <script src="{{ asset('assets/plugins/datatables-net-bs5/dataTables.bootstrap5.js') }}"></script>
@endpush

@push('custom-scripts')
  <script src="{{ asset('assets/js/data-table.js') }}"></script>
@endpush
