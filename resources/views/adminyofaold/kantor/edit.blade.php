@extends('layouts.masteradmin')

@section('content')
<div class="content-wrapper">
    <!-- Edit Location Form -->
    <section class="content-header">
        <h1>Edit Data<small> Lokasi</small></h1>
        <ol class="breadcrumb">
            <li><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> Beranda</a></li>
            <li><a href="{{ url('karyawan') }}"> Data Lokasi</a></li>
            <li class="active">Edit Lokasi</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="box box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title"><b>Edit Data Lokasi</b></h3>
                    </div>

                    <div class="box-body">
                        <form class="form-horizontal validate update-lokasi" method="POST" action="{{ route('kantor.update', $building->id) }}">
                            @csrf
                            @method('PUT')
                            <div class="box-body">
                                <!-- Nama Lokasi -->
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Nama Lokasi</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" name="name" value="{{ $building->name }}" required>
                                    </div>
                                </div>
                        
                                <!-- Alamat Lokasi -->
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Alamat Lokasi</label>
                                    <div class="col-sm-6">
                                        <textarea class="form-control address" name="address" rows="3" required>{{ $building->address }}</textarea>
                                    </div>
                                </div>
                        
                                <!-- Lainnya -->
                                <!-- Latitude, Longitude, Radius, dll. -->
                        
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
</div>

<!-- Javascript for Map -->
<script type="text/javascript">
    // Leaflet Map for Edit Location
    var curLocation = [{{ $building->latitude }}, {{ $building->longitude }}];

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
</script>
@endsection
