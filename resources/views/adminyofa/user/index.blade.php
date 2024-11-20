@extends('layouts.masteradmin')

@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/adminyofa">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">Data Admin</li>
    </ol>
</nav>
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <button type="button" class="btn btn-success btn-flat" data-bs-toggle="modal" data-bs-target="#modalAdd">
                    <i class="fa fa-plus"></i> Tambah Baru
                </button>

                <div class="table-responsive mt-3">
                    <table id="swdatatable" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Level</th>
                                <th class="text-center">Aksi</th>
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
                                <td>{{ $user->level_name }}</td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-warning btn-sm edit-btn" 
                                            data-id="{{ $user->user_id }}" 
                                            data-fullname="{{ $user->fullname }}" 
                                            data-username="{{ $user->username }}" 
                                            data-email="{{ $user->email }}" 
                                            data-level="{{ $user->level }}" 
                                            data-bs-toggle="modal" data-bs-target="#modalEdit">
                                        <i class="fa fa-pencil-square-o"></i> Ubah
                                    </button>
                                    <button type="button" class="btn btn-danger btn-sm delete-btn" 
                                            data-id="{{ $user->user_id }}">
                                        <i class="fa fa-trash"></i> Hapus
                                    </button>
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

<!-- Modal Tambah -->
<div class="modal fade" id="modalAdd" tabindex="-1" aria-labelledby="modalAddTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addUserForm">
                    @csrf
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
                    <div class="form-group mt-3">
                        <button type="button" class="btn btn-primary" id="btnSaveUser"><i class="fa fa-check"></i> Simpan</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><i class="fa fa-remove"></i> Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit -->
<div class="modal fade" id="modalEdit" tabindex="-1" aria-labelledby="modalEditTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editUserForm">
                    @csrf
                    <input type="hidden" name="id" id="edit-id">
                    <div class="form-group">
                        <label>Nama</label>
                        <input type="text" class="form-control" name="fullname" id="edit-fullname" required>
                    </div>
                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" class="form-control" name="username" id="edit-username" required>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" class="form-control" name="email" id="edit-email" required>
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" class="form-control" name="password">
                        <small class="text-danger">Kosongi jika tidak ingin mengubah password</small>
                    </div>
                    <div class="form-group">
                        <label>Level</label>
                        <select class="form-control" name="level" id="edit-level" required>
                            @foreach ($levels as $level)
                            <option value="{{ $level->level_id }}">{{ $level->level_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mt-3">
                        <button type="button" class="btn btn-primary" id="btnUpdateUser"><i class="fa fa-check"></i> Simpan</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><i class="fa fa-remove"></i> Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('plugin-scripts')
<script>
    $(document).ready(function () {
        // Tambah User
        $('#btnSaveUser').click(function () {
            $.ajax({
                url: '{{ route("user.store") }}',
                type: 'POST',
                data: $('#addUserForm').serialize(),
                success: function (response) {
                    alert('User berhasil ditambahkan');
                    location.reload();
                },
                error: function (xhr) {
                    alert('Gagal menambahkan user: ' + xhr.responseText);
                }
            });
        });

        // Edit User
        $('.edit-btn').click(function () {
            $('#edit-id').val($(this).data('id'));
            $('#edit-fullname').val($(this).data('fullname'));
            $('#edit-username').val($(this).data('username'));
            $('#edit-email').val($(this).data('email'));
            $('#edit-level').val($(this).data('level'));
        });

        $('#btnUpdateUser').click(function () {
            $.ajax({
                url: '{{ route("user.update") }}',
                type: 'POST',
                data: $('#editUserForm').serialize(),
                success: function (response) {
                    alert('User berhasil diupdate');
                    location.reload();
                },
                error: function (xhr) {
                    alert('Gagal memperbarui user: ' + xhr.responseText);
                }
            });
        });
    });
</script>
@endpush
