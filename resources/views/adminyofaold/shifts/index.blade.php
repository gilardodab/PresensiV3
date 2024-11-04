@extends('layouts.masteradmin') <!-- Atau layout yang sesuai -->

@section('content')
<div class="content-wrapper">
            <section class="content-header">
                <h1>Data<small> Shift</small></h1>
                <ol class="breadcrumb">
                    <li><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> Beranda</a></li>
                    <li class="active">Data Shift</li>
                </ol>
            </section>

            <section class="content">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="box box-solid">
                            <div class="box-header with-border">
                                <h3 class="box-title"><b>Data Shift</b></h3>
                                <div class="box-tools pull-right">
                                        <button type="button" class="btn btn-success btn-flat" data-toggle="modal" data-target="#modalAdd"><i class="fa fa-plus"></i> Tambah Baru</button>
     
                                </div>
                            </div>
                            <div class="box-body">
                                <div class="table-responsive">
                                    <table id="sw-datatable" class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th style="width:20px" class="text-center">No</th>
                                                <th class="text-center">ID</th>
                                                <th>Nama Shift</th>
                                                <th>Waktu Masuk</th>
                                                <th>Waktu Pulang</th>
                                                <th class="text-center">Jumlah Pegawai</th>
                                                <th style="width:100px">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($shifts as $shift)
                                                @php
                                                    $employees_count = \DB::table('employees')->where('shift_id', $shift->shift_id)->count();
                                                @endphp
                                                <tr>
                                                    <td class="text-center">{{ $loop->iteration }}</td>
                                                    <td class="text-center">{{ $shift->shift_id }}</td>
                                                    <td>{{ $shift->shift_name }}</td>
                                                    <td>{{ $shift->time_in }}</td>
                                                    <td>{{ $shift->time_out }}</td>
                                                    <td class="text-center"><span class="badge bg-yellow">{{ $employees_count }}</span></td>
                                                    <td>
                                                        <div class="btn-group">
                                                                <a href="#modalEdit" class="btn btn-warning btn-xs enable-tooltip" title="Edit" data-toggle="modal"
                                                                   onclick="getElementById('txtid').value='{{ $shift->shift_id }}';getElementById('txtname').value='{{ $shift->shift_name }}';getElementById('txtin').value='{{ $shift->time_in }}';getElementById('txtout').value='{{ $shift->time_out }}';">
                                                                    <i class="fa fa-pencil-square-o"></i> Ubah
                                                                </a>
                                                                <button data-id="{{ $shift->shift_id }}" class="btn btn-xs btn-danger delete" title="Hapus"><i class="fa fa-trash-o"></i> Hapus</button>
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

            <!-- Add Shift Modal -->
            <div class="modal fade" id="modalAdd" data-backdrop="static" data-keyboard="false">
                <div class="modal-dialog modal-md">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">Tambah Baru</h4>
                        </div>
                        <form class="form validate add-shift">
                            <div class="modal-body">
                                <div class="form-group">
                                    <label>Nama Shift</label>
                                    <input type="text" class="form-control" name="shift_name" required>
                                </div>

                                <div class="form-group">
                                    <label>Waktu Masuk</label>
                                    <div class="input-group">
                                        <input type="text" name="time_in" class="form-control timepicker" data-date-format="HH:mm:ss" value="07:30:00" required>
                                        <div class="input-group-addon">
                                            <i class="fa fa-clock-o"></i>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Waktu Pulang</label>
                                    <div class="input-group">
                                        <input type="text" name="time_out" class="form-control timepicker" required>
                                        <div class="input-group-addon">
                                            <i class="fa fa-clock-o"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary pull-left"><i class="fa fa-check"></i> Simpan</button>
                                <button type="button" class="btn btn-danger pull-right" data-dismiss="modal"><i class="fa fa-remove"></i> Batal</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Edit Shift Modal -->
            <div class="modal fade" id="modalEdit" data-backdrop="static" data-keyboard="false">
                <div class="modal-dialog modal-md">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">Update Data</h4>
                        </div>
                        <form class="form update-shift" method="post">
                            <input type="hidden" name="id" id="txtid" required readonly>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label>Nama Shift</label>
                                    <input type="text" class="form-control" id="txtname" name="shift_name" required>
                                </div>

                                <div class="form-group">
                                    <label>Waktu Masuk</label>
                                    <div class="input-group">
                                        <input type="text" name="time_in" id="txtin" class="form-control timepicker" data-date-format="HH:mm:ss" required>
                                        <div class="input-group-addon">
                                            <i class="fa fa-clock-o"></i>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Waktu Pulang</label>
                                    <div class="input-group">
                                        <input type="text" name="time_out" id="txtout" class="form-control timepicker" required>
                                        <div class="input-group-addon">
                                            <i class="fa fa-clock-o"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary pull-left"><i class="fa fa-check"></i> Simpan</button>
                                <button type="button" class="btn btn-danger pull-right" data-dismiss="modal"><i class="fa fa-remove"></i> Batal</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
</div>
<script>
    var shiftStoreUrl = "{{ route('shift.store') }}";
    var shiftUpdateUrl = "{{ route('shift.update', '') }}";
    //delete shift.destroy with id
    var shiftDeleteUrl = "{{ route('shift.destroy', '') }}";
   
  </script> 
  <script src="{{ asset('admin/js/shifts.js') }}"></script>
@endsection


  