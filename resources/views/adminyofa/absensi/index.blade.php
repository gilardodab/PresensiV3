@extends('layouts.masteradmin')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h1>Detail<small> Absensi</small></h1>
        <ol class="breadcrumb">
            <li><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> Beranda</a></li>
            <li><a href="javascript:history.back()">Data Absensi</a></li>
            <li class="active">Detail Absen</li>
        </ol>
    </section>
    @switch(request()->get('op'))
        @case('views')
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
                                <h4>Nama: <span class="employees_name">{{ $employees->employees_name }}</span></h4>
                                <h4>Jabatan: {{ $employees->position->position_name }}</h4>
                                <hr>
                                <!-- Add your form or content here -->
                                <div class="row">
                                    <div class="col-md-4">
                                        <input type="hidden" class="id" value="{{ $id }}" readonly>
                                        <div class="form-group">
                                            <select class="form-control month" required>
                                                @php
                                                    $months = [
                                                        '01' => 'Januari',
                                                        '02' => 'Februari',
                                                        '03' => 'Maret',
                                                        '04' => 'April',
                                                        '05' => 'Mei',
                                                        '06' => 'Juni',
                                                        '07' => 'Juli',
                                                        '08' => 'Agustus',
                                                        '09' => 'September',
                                                        '10' => 'Oktober',
                                                        '11' => 'November',
                                                        '12' => 'Desember'
                                                    ];
                                                @endphp
                                        
                                                @foreach($months as $value => $name)
                                                    <option value="{{ $value }}" {{ $month == (int)$value ? 'selected' : '' }}>{{ $name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        
                                    </div>
                                
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <select class="form-control year" required>
                                                @php
                                                    $currentYear = date('Y');
                                                @endphp
                                                @for($i = $currentYear; $i < $currentYear + 50; $i++)
                                                    <option value="{{ $i }}" {{ $i == $currentYear ? 'selected' : '' }}>
                                                        {{ $i }}
                                                    </option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                
                                    <div class="col-md-4">
                                        <div class="btn-group pull-right">
                                            <button type="button" class="btn btn-primary btn-sortir">Tampilkan</button>
                                            <button type="button" class="btn btn-warning">Ekspor/Cetak</button>
                                            <button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                <span class="caret"></span>
                                                <span class="sr-only">Toggle Dropdown</span>
                                            </button>
                                            <ul class="dropdown-menu" role="menu">
                                                <li><a href="#" class="btn-print" data-id="pdf">PDF</a></li>
                                                <li><a href="#" class="btn-print" data-id="excel">EXCEL</a></li>
                                                <li><a href="#" class="btn-print" data-id="print">PRINT</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                
                                <h3>Absensi Bulan : <span class="result-month">{{ $months[$month] }}</span></h3>

                                <div class="loaddata">
                                    @include('adminyofa.absensi.partials.absensi_table', ['presences' => $presences, 'shift' => $shift])
                                </div>

                                <div class="modal fade" id="modal-location">
                                    <div class="modal-dialog">
                                      <div class="modal-content">
                                        <div class="modal-header">
                                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span></button>
                                          <h4 class="modal-title">Lokasi Absen <span class="modal-title-name"></span></h4>
                                        </div>
                                        <div class="modal-body">
                                          <div id="iframe-map"></div>
                                        </div>
                                        <div class="modal-footer">
                                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        </div>
                                      </div>
                                      <!-- /.modal-content -->
                                    </div>
                                    <!-- /.modal-dialog -->
                                  </div>
                                  <!-- /.modal -->
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            @break
        @case('view-present')


            <section class="content"><input type="hidden" id="id" value="'.$row['id'].'" readonly>
                <div class="row">
                  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="box box-solid">
                      <div class="box-header with-border">
                        <h3 class="box-title"><b>Data Absensi Karyawan: {{ $employees->employees_name }}</b></h3>
                        <div class="box-tools pull-right">
                          <button type="button" onclick="history.back()" class="btn btn-default btn-flat">Kembali</button>
                        </div>
                      </div>
              
                      <div class="box-body">
                          <div class="loaddata"></div>
                      </div>
                    </div>
                  </div>
                </div>
            </section>
        @break 
        @default


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
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th style="width: 10px">No</th>
                                                <th>ID Karyawan</th>
                                                <th>Nama</th>
                                                <th>Email</th>
                                                <th>Jabatan</th>
                                                <th>Shift</th>
                                                <th>Lokasi</th>
                                                <th style="width:150px" class="text-right">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($employees as $employee)
                                                <tr>
                                                    <td class="text-center">{{ $loop->iteration }}</td>
                                                    <td>{{ $employee->employees_code }}</td>
                                                    <td>{{ $employee->employees_name }}</td>
                                                    <td>{{ $employee->employees_email }}</td>
                                                    <td>{{ $employee->position->position_name }}</td>
                                                    <td>{{ $employee->shift->shift_name }}</td>
                                                    <td>{{ $employee->building->name }}</td>
                                                    <td class="text-right">
                                                        <div class="btn-group">
                                                            <a href="{{ url('absensi?op=views&id=' . $employee->id) }}" class="btn btn-warning btn-xs enable-tooltip" title="Detail"><i class="fa fa-eye" aria-hidden="true"></i> Detail</a>
                                                        </div>
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
            @break
    @endswitch
</div>
@endsection
@include('adminyofa.absensi.script')