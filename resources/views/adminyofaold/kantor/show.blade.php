<!-- resources/views/adminyofa/kantor/show.blade.php -->

@extends('layouts.masteradmin')

@section('content')
<div class="container">
    <h1>Detail Lokasi Kantor</h1>

    <div class="card">
        <div class="card-header">
            Informasi Kantor
        </div>
        <div class="card-body">
            <h5 class="card-title">Nama Lokasi: {{ $building->name }}</h5>
            <p class="card-text">Alamat: {{ $building->address }}</p>
            <p class="card-text">Latitude: {{ $building->latitude }}</p>
            <p class="card-text">Longitude: {{ $building->longitude }}</p>
            <p class="card-text">Radius: {{ $building->radius }} meter</p>

            <a href="{{ route('adminyofa.kantor.index') }}" class="btn btn-primary">Kembali ke Daftar Kantor</a>
        </div>
    </div>
</div>
@endsection
