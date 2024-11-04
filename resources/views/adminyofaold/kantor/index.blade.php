@extends('layouts.masteradmin')

@section('content')
<div class="content-wrapper">
@if (request()->route()->getName() == 'kantor.create')
    <!-- Add Location Form -->
    <section class="content-header">
        <h1>Tambah Data<small> Lokasi</small></h1>
        <ol class="breadcrumb">
            <li><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> Beranda</a></li>
            <li><a href="{{ url('karyawan') }}"> Data Lokasi</a></li>
            <li class="active">Tambah Lokasi</li>
        </ol>
    </section>

    <!-- Add Location Section -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="box box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title"><b>Tambah Data Lokasi</b></h3>
                    </div>

                    <div class="box-body">
                        <form class="form-horizontal validate add-lokasi" method="POST" action="{{ route('kantor.store') }}">
                            @csrf
                            <div class="box-body">

                                <!-- Nama Lokasi -->
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Nama Lokasi</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" name="name" value="{{ old('name') }}" required>
                                    </div>
                                </div>

                                <!-- Alamat Lokasi -->
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Alamat Lokasi</label>
                                    <div class="col-sm-6">
                                        <textarea class="form-control address" name="address" rows="3" required>{{ old('address') }}</textarea>
                                    </div>
                                </div>

                                <!-- Google Map -->
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Google Map</label>
                                    <div class="col-sm-6">
                                        <div id="MapLocation" style="height: 350px"></div>
                                        <br>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <input class="form-control" id="Latitude" placeholder="Latitude" name="latitude" value="{{ old('latitude') }}" required>
                                            </div>
                                            <div class="col-lg-6">
                                                <input class="form-control" id="Longitude" placeholder="Longitude" name="longitude" value="{{ old('longitude') }}" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Radius -->
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Radius</label>
                                    <div class="col-sm-6">
                                        <div class="input-group">
                                            <input type="number" class="form-control" name="radius" value="{{ old('radius') }}" required>
                                            <span class="input-group-addon">M</span>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer">
                                <div class="col-sm-2"></div>
                                <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Simpan</button>
                                <a class="btn btn-danger" href="{{ route('adminyofa.kantor.index') }}"><i class="fa fa-remove"></i> Batal</a>
                            </div>
                            <!-- /.box-footer -->
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@else
    <!-- Default case for showing data table -->
    <section class="content-header">
        <h1>Data<small> Lokasi</small></h1>
        <ol class="breadcrumb">
            <li><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> Beranda</a></li>
            <li class="active">Data Lokasi</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="box box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title"><b>Data Lokasi</b></h3>
                        <div class="box-tools pull-right">
                            <a href="{{ url('kantor/create') }}" class="btn btn-success btn-flat">
                                <i class="fa fa-plus"></i> Tambah Baru
                            </a>
                        </div>
                    </div>

                    <div class="box-body">
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
                                            
                                            <form id="delete-form-{{ $building->building_id }}" action="{{ route('kantor.destroy', $building->building_id) }}" method="POST" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <a href="{{ route('kantor.destroy', $building->building_id) }}" class="btn btn-xs btn-danger" data-confirm-delete>
                                                    <i class="fa fa-trash-o"></i> Hapus
                                                </a>
                                            </form>                                            
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endif
</div>

<!-- Javascript for Map and SweetAlert -->
<script type="text/javascript">
    // Leaflet Map and Geolocation
    navigator.geolocation.getCurrentPosition(function(location) {
        var latlng = new L.LatLng(location.coords.latitude, location.coords.longitude);
      
        $("#Latitude").val(location.coords.latitude);
        $("#Longitude").val(location.coords.longitude);
      
        var curLocation = latlng;
        var map = L.map('MapLocation').setView(curLocation, 20);
        L.tileLayer('https://{s}.tile.osm.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        var marker = new L.marker(curLocation, {
            draggable: true
        }).addTo(map);

        marker.on('dragend', function(event) {
            var position = marker.getLatLng();
            $("#Latitude").val(position.lat);
            $("#Longitude").val(position.lng);
        });

        // Update map when latitude/longitude input changes
        $("#Latitude, #Longitude").change(function() {
            var position = [parseFloat($("#Latitude").val()), parseFloat($("#Longitude").val())];
            marker.setLatLng(position).update();
            map.setView(position, 20);
        });
    });

</script>
@endsection
