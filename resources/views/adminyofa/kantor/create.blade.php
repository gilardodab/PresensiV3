@extends('layouts.masteradmin')

@section('content')
<section class="content-header">
    <h1>Tambah Data<small> Lokasi</small></h1>
    <ol class="breadcrumb">
        <li><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> Beranda</a></li>
        <li><a href="{{ url('/lokasi') }}"> Data Lokasi</a></li>
        <li class="active">Tambah Lokasi</li>
    </ol>
</section>

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
                                            <input class="form-control" id="Latitude" placeholder="Latitude" name="latitude" value="{{ old('latitude') }}" readonly required>
                                        </div>
                                        <div class="col-lg-6">
                                            <input class="form-control" id="Longitude" placeholder="Longitude" name="longitude" value="{{ old('longitude') }}" readonly required>
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
                            <a class="btn btn-danger" href="{{ route('kantor.index') }}"><i class="fa fa-remove"></i> Batal</a>
                        </div>
                        <!-- /.box-footer -->
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@include('adminyofa.kantor.script')
