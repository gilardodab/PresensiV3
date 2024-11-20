@extends('layouts.masteradmin')
@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/adminyofa">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">Data Divisi</li>
    </ol>
</nav>

<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title">Data Divisi</h6>
                <div class="mb-3">
                    <div class="row mb-3">
                        <div class="col-6">
                            @if ($user->level == 1)
                                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalAdd">
                                    Tambah
                                </button>
                            @else
                                <button type="button" class="btn btn-success access-failed">
                                    <i class="fa fa-plus"></i> Tambah Baru
                                </button>
                            @endif
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table id="swdatatable" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-center" style="width:20px">No</th>
                                    <th>Nama Divisi</th>
                                    <th class="text-center">Jumlah Karyawan</th>
                                    <th style="width:100px">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $no = 0; @endphp
                                @foreach ($jabatan as $item)
                                    @php $no++; @endphp
                                    <tr>
                                        <td class="text-center">{{ $no }}</td>
                                        <td>{{ $item->position_name }}</td>
                                        <td class="text-center"><span class="badge bg-warning">{{ $item->employees_count }}</span></td>
                                        <td>
                                            <div class="btn-group">
                                                @if ($user->level == 1)
                                                    <a href="#modalEdit" class="btn btn-warning btn-xs" title="Edit" data-bs-toggle="modal" data-bs-target="#ModalEdit" onclick="editData('{{ $item->position_id }}', '{{ $item->position_name }}')">
                                                        <i class="fa fa-pencil-square-o"></i> Ubah
                                                    </a>
                                                    <button data-id="{{ $item->position_id }}" class="btn btn-xs btn-danger delete" title="Hapus">
                                                        <i class="fa fa-trash-o"></i> Hapus
                                                    </button>
                                                @else
                                                    <button type="button" class="btn btn-warning btn-xs access-failed" title="Edit">
                                                        <i class="fa fa-pencil-square-o"></i> Ubah
                                                    </button>
                                                    <button type="button" class="btn btn-xs btn-danger access-failed" title="Hapus">
                                                        <i class="fa fa-trash-o"></i> Hapus
                                                    </button>
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
</div>

<!-- Modal Edit -->
<div class="modal fade" id="ModalEdit" tabindex="-1" aria-labelledby="ModalEditTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalEditTitle">Edit Data Divisi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <form class="form update-jabatan" method="post">
                @csrf
                <input type="hidden" name="id" id="txtid" required readonly>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nama</label>
                        <input type="text" class="form-control" name="position_name" id="txtnama" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Add -->
<div class="modal fade" id="modalAdd" tabindex="-1" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Tambah Baru</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <form class="form add-jabatan" method="post">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nama Divisi</label>
                        <input type="text" class="form-control" name="position_name" id="nama" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    var JabatanStoreUrl = "{{ route('jabatan.store') }}";
    var JabatanUpdateUrl = "{{ route('jabatan.update', '') }}";
    var JabatanDeleteUrl = "{{ route('jabatan.destroy', '') }}";

    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function loading() {
            $(".loading").show().delay(1500).fadeOut(500);
        }

        /* ----------- Add ------------ */
        $('.add-jabatan').submit(function(e) {
            e.preventDefault();
            if ($('#nama').val() == '') {
                swal({ title: 'Oops!', text: 'Harap bidang inputan tidak boleh ada yang kosong.', icon: 'error', timer: 1500 });
                return;
            }
            loading();
            $.ajax({
                url: JabatanStoreUrl,
                type: "POST",
                data: new FormData(this),
                processData: false,
                contentType: false,
                cache: false,
                async: false,
                beforeSend: function() {
                    loading();
                },
                success: function(data) {
                    if (data == 'success') {
                        swal({ title: 'Berhasil!', text: 'Jabatan berhasil disimpan.', icon: 'success', timer: 1500 });
                        $('#modalAdd').modal('hide');
                        setTimeout(function() { location.reload(); }, 1500);
                    } else {
                        swal({ title: 'Oops!', text: data, icon: 'error', timer: 1500 });
                    }
                },
                complete: function() {
                    $(".loading").hide();
                }
            });
        });

        /* -------------------- Edit ------------------- */
        $('.update-jabatan').submit(function(e) {
            e.preventDefault();
            if ($('#txtnama').val() == '') {
                swal({ title: 'Oops!', text: 'Harap bidang inputan tidak boleh ada yang kosong.', icon: 'error', timer: 1500 });
                return;
            }
            loading();
            var formData = new FormData(this);
            formData.append('_method', 'PUT'); // Append _method for PUT request
            $.ajax({
                url: JabatanUpdateUrl + '/' + $('#txtid').val(),
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                cache: false,
                async: false,
                beforeSend: function() {
                    loading();
                },
                success: function(data) {
                    if (data == 'success') {
                        swal({ title: 'Berhasil!', text: 'Jabatan berhasil diubah.', icon: 'success', timer: 1500 });
                        $('#modalEdit').modal('hide');
                        setTimeout(function() { location.reload(); }, 1500);
                    } else {
                        swal({ title: 'Oops!', text: data, icon: 'error', timer: 1500 });
                    }
                },
                complete: function() {
                    $(".loading").hide();
                }
            });
        });

        /* ------------ Delete ------------- */
        $(document).on('click', '.delete', function() {
            var id = $(this).data('id');
            swal({
                text: "Anda yakin menghapus data ini?",
                icon: "warning",
                buttons: {
                    cancel: true,
                    confirm: true,
                },
                dangerMode: true
            }).then((willDelete) => {
                if (willDelete) {
                    loading();
                    $.ajax({
                        url: JabatanDeleteUrl + '/' + id,
                        type: 'DELETE',
                        success: function(data) {
                            if (data == 'success') {
                                swal({ title: 'Berhasil!', text: 'Data berhasil dihapus.', icon: 'success', timer: 1500 });
                                setTimeout(function() { location.reload(); }, 1500);
                            } else {
                                swal({ title: 'Gagal!', text: data, icon: 'error', timer: 1500 });
                            }
                        }
                    });
                }
            });
        });
    });

    function editData(id, name) {
        document.getElementById('txtid').value = id;
        document.getElementById('txtnama').value = name;
    }
</script>
@endsection
