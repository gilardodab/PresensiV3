@extends('layouts.masteradmin')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h1>Detail<small> Absensi</small></h1>
        <ol class="breadcrumb">
            <li><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> Beranda</a></li>
            <li><a href="{{ route('adminyofa.absensi.index') }}">Data Absensi</a></li>
            <li class="active">Detail Absen</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="box box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title"><b>Detail Absensi</b></h3>
                        <div class="box-tools pull-right">
                            <button type="button" onclick="history.back()" class="btn btn-default btn-flat">Kembali</button>
                        </div>
                    </div>
                    <div class="box-body">
                        <h4>Nama: <span class="employees_name">{{ $employee->employees_name }}</span></h4>
                        <h4>Jabatan: {{ $employee->position->position_name }}</h4>
                        <hr>
                        <div class="loaddata">
                            <!-- Tempat menampilkan data absensi yang akan dimuat secara dinamis -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@include('adminyofa.absensi.script')

