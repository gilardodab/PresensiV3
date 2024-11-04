@extends('layouts.masteradmin')
@section('content')
    <section class="content-header">
        <h1>Data<small> Jabatan</small></h1>
        <ol class="breadcrumb">
            <li><a href="./"><i class="fa fa-dashboard"></i> Beranda</a></li>
            <li class="active">Data Jabatan</li>
        </ol>
    </section>

    <div class="content-wrapper">
        <section class="content">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="box box-solid">
                        <div class="box-header with-border">
                            <h3 class="box-title"><b>Data Jabatan</b></h3>
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
                                            <th>Nama Jabatan</th>
                                            <th class="text-center">Jumlah Karyawan</th>
                                            <th style="width:100px">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $no = 0; @endphp
                                        @foreach ($jabatan as $jabatan)
                                            @php $no++; @endphp
                                            <tr>
                                                <td class="text-center">{{ $no }}</td>
                                                <td class="text-center">{{ $jabatan->position_id }}</td>
                                                <td>{{ $jabatan->position_name }}</td>
                                                <td class="text-center"><span class="badge bg-yellow">{{ $jabatan->employees_count }}</span></td>
                                                <td>
                                                    <div class="btn-group">
                                                        @if ($user->level== 1) 
                                                            <a href="#modalEdit" class="btn btn-warning btn-xs enable-tooltip" title="Edit" data-toggle="modal" onclick="document.getElementById('txtid').value='{{ $jabatan->position_id }}'; document.getElementById('txtnama').value='{{ $jabatan->position_name }}';"><i class="fa fa-pencil-square-o"></i> Ubah</a>

                                                            <buton data-id="{{ $jabatan->position_id }}" class="btn btn-xs btn-danger delete" title="Hapus"><i class="fa fa-trash-o"></i> Hapus</button>
                                                        @else
                                                            <button type="button" class="btn btn-warning btn-xs access-failed enable-tooltip" title="Edit"><i class="fa fa-pencil-square-o"></i> Ubah</button>
                                                            <button type="button" class="btn btn-xs btn-danger access-failed" title="Hapus"><i class="fa fa-trash-o"></i> Hapus</button>
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

    <!-- Add -->
    <div class="modal fade" id="modalAdd" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">Tambah Baru</h4>
                </div>
                <form class="form validate add-jabatan">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Nama Jabatan</label>
                            <input type="text" class="form-control" name="position_name" id="nama" required>
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

    <!-- MODAL EDIT -->
    <div class="modal fade" id="modalEdit" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">Update Data</h4>
                </div>
                <form class="form update-jabatan" method="post">
                    <input type="hidden" name="id" id="txtid" required readonly>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Nama</label>
                            <input type="text" class="form-control" name="position_name" id="txtnama" required>
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
    {{-- <script src="{{ asset('admin/js/jabatan.js') }}"></script> --}}
    <script>
    var JabatanStoreUrl ="{{ route('jabatan.store') }}";
    var JabatanUpdateUrl = "{{ route('jabatan.update', '') }}";
    var JabatanDeleteUrl = "{{ route('jabatan.destroy', '') }}";
    </script>
@endsection
