@extends('layouts.masteradmin')

@section('content')
    <div class="content-wrapper">
    <section class="content-header">
        <h1>Data<small> Absensi</small></h1>
        <ol class="breadcrumb">
            <li><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> Beranda</a></li>
            <li class="active">Data Absensi</li>
        </ol>
    </section>

        <section class="content">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="box box-solid">
                        <div class="box-header with-border">
                            <h3 class="box-title"><b>Data Absensi</b></h3>
                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-laporan">Ekspor Semua</button>
                            </div>
                        </div>
                        <div class="box-body">
                            <div class="table-responsive">
                                <table id="swdatatable" class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>No. Hp</th>
                                            <th>Nama</th>
                                            <th>Email</th>
                                            <th>Jabatan</th>
                                            <th>Shift</th>
                                            <th>Lokasi</th>
                                            <th class="text-right">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($employees as $key => $employee)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $employee->employees_code }}</td>
                                                <td>{{ $employee->employees_name }}</td>
                                                <td>{{ $employee->employees_email }}</td>
                                                <td>{{ $employee->position->position_name }}</td>
                                                <td>{{ $employee->shift->shift_name }}</td>
                                                <td>{{ $employee->building->name }}</td>
                                                <td class="text-right">
                                                    <a href="{{ route('absensi.show', $employee->id) }}" class="btn btn-warning btn-xs enable-tooltip" title="Detail"><i class="fa fa-eye" aria-hidden="true"></i> Detail</a>
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
    </div>
@endsection
