@extends('layouts.masteradmin') <!-- Atau layout yang sesuai -->

@section('content')
<div class="content-wrapper">
            <section class="content-header">
                <h1>Admin</h1>
                <ol class="breadcrumb">
                    <li><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> Beranda</a></li>
                    <li class="active">Admin</li>
                </ol>
            </section>

            <section class="content">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="box box-solid">
                            <div class="box-header with-border">
                                <h3 class="box-title"><b>Admin</b></h3>
                                <div class="box-tools pull-right">
                                    @if($user->level == 1)
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
                                                <th style="width: 10px">No</th>
                                                <th>Nama</th>
                                                <th>Username</th>
                                                <th>Email</th>
                                                <th>Registrasi</th>
                                                <th>Level</th>
                                                <th style="width:120px" class="text-center">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php $no = 1; @endphp
                                            @foreach ($users as $user)
                                                <tr>
                                                    <td class="text-center">{{ $no++ }}</td>
                                                    <td>{{ $user->fullname }}</td>
                                                    <td>{{ $user->username }}</td>
                                                    <td>{{ $user->email }}</td>
                                                    <td>{{ tgl_indo($user->registered) }} - {{ jam_indo($user->registered) }}</td>
                                                    <td>{{ $user->level_name }}</td>
                                                    <td class="text-right">
                                                        <div class="btn-group btn-group-xs">
                                                            @if($user->level == 1)
                                                                <a href="#modalEdit" class="btn btn-warning btn-xs enable-tooltip" title="Edit" data-toggle="modal"
                                                                   onclick="getElementById('txtid').value='{{ $user->user_id }}';getElementById('txtnama').value='{{ $user->fullname }}';getElementById('txtuser').value='{{ $user->username }}';getElementById('txtemail').value='{{ $user->email }}';getElementById('txtlevel').value='{{ $user->level }}';">
                                                                    <i class="fa fa-pencil-square-o"></i> Ubah
                                                                </a>
                                                                <button data-id="{{ epm_encode($user->user_id) }}" class="btn btn-sm btn-danger delete" title="Hapus"><i class="fa fa-trash-o"></i> Hapus</button>
                                                            @elseif($user_id == $SESSION_ID)
                                                                <a href="#modalEdit" class="btn btn-warning btn-xs enable-tooltip" title="Edit" data-toggle="modal"
                                                                   onclick="getElementById('txtid').value='{{ $user->user_id }}';getElementById('txtnama').value='{{ $user->fullname }}';getElementById('txtuser').value='{{ $user->username }}';getElementById('txtemail').value='{{ $user->email }}';getElementById('txtlevel').value='{{ $user->level }}';">
                                                                    <i class="fa fa-pencil-square-o"></i> Ubah
                                                                </a>
                                                            @else
                                                                <button class="btn btn-sm btn-warning access-failed" title="Ubah"><i class="fa fa-pencil-square-o"></i> Ubah</button>
                                                            @endif

                                                            @if($user->level == 1)
                                                                <button data-id="{{ epm_encode($user->user_id) }}" class="btn btn-sm btn-danger delete" title="Hapus"><i class="fa fa-trash-o"></i> Hapus</button>
                                                            @else
                                                                <button class="btn btn-sm btn-danger access-failed" title="Hapus"><i class="fa fa-trash-o"></i> Hapus</button>
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

            <!-- Add Modal -->
            <div class="modal fade" id="modalAdd" data-backdrop="static" data-keyboard="false">
                <div class="modal-dialog modal-md">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">Tambah Baru</h4>
                        </div>
                        <form class="form add-user" method="post">
                            <div class="modal-body">
                                <div class="form-group">
                                    <label>Nama</label>
                                    <input type="text" class="form-control" name="fullname" required>
                                </div>

                                <div class="form-group">
                                    <label>Username</label>
                                    <input type="text" class="form-control" name="username" required>
                                </div>

                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="email" class="form-control" name="email" required>
                                </div>

                                <div class="form-group">
                                    <label>Password</label>
                                    <input type="password" class="form-control" name="password" required>
                                </div>

                                <div class="form-group">
                                    <label>Level</label>
                                    <select class="form-control" name="level" required>
                                        <option value="">- Pilih -</option>
                                        @foreach ($levels as $level)
                                            <option value="{{ $level->level_id }}">{{ $level->level_name }}</option>
                                        @endforeach
                                    </select>
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

            <!-- Edit Modal -->
            <div class="modal fade" id="modalEdit" data-backdrop="static" data-keyboard="false">
                <div class="modal-dialog modal-md">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">Edit User</h4>
                        </div>
                        <form class="form update-user" method="post">
                            <input type="hidden" name="id" id="txtid" required readonly>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label>Nama</label>
                                    <input type="text" class="form-control" id="txtnama" name="fullname" required>
                                </div>

                                <div class="form-group">
                                    <label>Username</label>
                                    <input type="text" class="form-control" id="txtuser" name="username" required>
                                </div>

                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="email" class="form-control" id="txtemail" name="email" required>
                                </div>

                                <div class="form-group">
                                    <label>Password</label>
                                    <input type="password" class="form-control" name="password">
                                    <small class="text-danger">Kosongan jika tidak ingin diubah passwordnya</small>
                                </div>

                                <div class="form-group">
                                    @if($user->level == 1)
                                        <label>Level</label>
                                        <select class="form-control" name="level" id="txtlevel" required>
                                            <option value="">- Pilih -</option>
                                            @foreach ($levels as $level)
                                                <option value="{{ $level->level_id }}">{{ $level->level_name }}</option>
                                            @endforeach
                                        </select>
                                    @else
                                        <input type="hidden" name="level" id="txtlevel" required readonly>
                                    @endif
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
@endsection

