@extends('layouts.masteradmin')
@section('content')
    <section class="content-header">
        <h1>Data<small> Permohonan Cuti</small></h1>
        <ol class="breadcrumb">
            <li><a href="./"><i class="fa fa-dashboard"></i> Beranda</a></li>
            <li class="active">Data Permohonan Cuti</li>
        </ol>
    </section>

    <div class="content-wrapper">
        <section class="content">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="box box-solid">
                        <div class="box-header with-border">
                            <h3 class="box-title"><b>Data Permohonan Cuti</b></h3>
                            <div class="box-tools pull-right">
                                @if ($user->level == 1)
                                    <button type="button" class="btn btn-success btn-flat" data-toggle="modal" data-target="#modalAdd"><i class="fa fa-plus"></i> Tambah Baru</button>
                                @else
                                    <button type="button" class="btn btn-success btn-flat access-failed"><i class="fa fa-plus"></i> Tambah Baru</button>
                                @endif
                            </div>
                        </div>
                        <div class="box-body">
                            <div class="table-responsive">
                                <table id="swdatatable" class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th style="width:20px" class="text-center">No</th>
                                            <th class="text-center">ID</th>
                                            <th class="text-center">Nama</th>
                                            <th class="text-center">Tanggal</th>
                                            <th class="text-center">Total</th>
                                            <th class="text-center">Keterangan</th>
                                            <th class="text-center">Status</th>
                                            <th style="width:100px">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($cuties as $index => $cuti)
                                            <tr>
                                                <td class="text-center">{{ $index + 1 }}</td>
                                                <td class="text-center">{{ $cuti['cuty_id'] }}</td>
                                                <td class="text-center">{{ $cuti->employees['employees_name'] }}</td>
                                                <td class="text-center">{{ tgl_ind($cuti['cuty_start']) }} s/d {{ tgl_ind($cuti['cuty_end']) }}</td>
                                                <td class="text-center"><label class="label label-warning">{{ $cuti['cuty_total'] }}</label></td>
                                                <td class="text-center">{{ $cuti['cuty_description'] }}</td>
                                                <td class="text-center">
                                                    @if ($cuti['cuty_status'] == 1)
                                                        <label class="label label-primary">Disetujui</label>
                                                    @elseif ($cuti['cuty_status'] == 2)
                                                        <label class="label label-danger">Ditolak</label>
                                                    @else
                                                        <label class="label label-warning">Menunggu</label>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    <div class="btn-group">
                                                    @if ($user->level == 1)
                                                      <div class="btn-group">
                                                        <button type="button" class="btn btn-warning btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Proses
                                                          <span class="caret"></span>
                                                          <span class="sr-only">Toggle Dropdown</span>
                                                        </button>
                                                        <ul class="dropdown-menu" role="menu">
                                                          <li><a href="javascript:void(0);" data-id="{{$cuti['cuty_id']}}" data-status="1" class="update-status">Setujui</a></li>
                                                          <li><a href="javascript:void(0);" data-id="{{$cuti['cuty_id']}}" data-status="2" class="update-status">Tidak disetujui</a></li>
                                                        </ul>
                                                      </div>
                                                      <a href="{{ route('cuti.print', $cuti['cuty_id']) }}" target="_blank" class="btn btn-xs btn-danger " title="Print">
                                                        <i class="fa fa-print" aria-hidden="true"></i> Print
                                                    </a>
                                                    
                                                    @else
                                                      <button type="button" class="btn btn-warning btn-xs access-failed enable-tooltip" title="Edit"><i class="fa fa-pencil-square-o"></i> Ubah</button>
                                                      <buton type="button" class="btn btn-xs btn-danger access-failed" title="Hapus"><i class="fa fa-trash-o"></i> Hapus</button>
                                                    @endif
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
    </div>
</div>
<script>
    var cutiUpdateUrl = "{{ route('cuti.updateStatus') }}";
  </script> 
  <script src="{{ asset('admin/js/cuti.js') }}"></script>
@endsection