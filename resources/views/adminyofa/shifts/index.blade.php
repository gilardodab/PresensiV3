@extends('layouts.masteradmin')
@push('plugin-styles')
  <link href="{{ asset('assets/plugins/datatables-net-bs5/dataTables.bootstrap5.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/timepicker/bootstrap-timepicker.min.css') }}" rel="stylesheet" />
@endpush

@section('content')
<nav class="page-breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
    <li class="breadcrumb-item active" aria-current="page">Data Jam Kerja</li>
  </ol>
</nav>

<div class="row">
  <div class="col-md-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h6 class="card-title">Data Jam Kerja</h6>
        @if ($user->level == 1)
          <p class="text-muted mb-3">
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalAdd">
              Tambah Baru
            </button>
          </p>
        @else
          <button type="button" class="btn btn-success access-failed">
            <i class="fa fa-plus"></i> Tambah Baru
          </button>
        @endif

        <!-- Modal Tambah -->
        <div class="modal fade" id="modalAdd" tabindex="-1" aria-labelledby="modalAddTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="modalAddTitle">Tambah Jam Kerja</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
              </div>
              <form class="form add-shift">
                @csrf
                <div class="modal-body">
                  <div class="form-group">
                    <label>Nama Shift</label>
                    <input type="text" class="form-control" name="shift_name" required>
                  </div>
                  <div class="form-group">
                    <label>Waktu Masuk</label>
                    <div class="input-group">
                      <input type="text" name="time_in" class="form-control timepicker" required>
                      <div class="input-group-text">
                        <i class="fa fa-clock-o"></i>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label>Waktu Pulang</label>
                    <div class="input-group">
                      <input type="text" name="time_out" class="form-control timepicker" required>
                      <div class="input-group-text">
                        <i class="fa fa-clock-o"></i>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                  <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
              </form>
            </div>
          </div>
        </div>

        <!-- Tabel Data -->
        <div class="table-responsive">
          <table id="dataTableExample" class="table">
            <thead>
              <tr>
                <th style="width:20px" class="text-center">No</th>
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
                <td>{{ $shift->shift_name }}</td>
                <td>{{ $shift->time_in }}</td>
                <td>{{ $shift->time_out }}</td>
                <td class="text-center"><span class="badge bg-warning">{{ $employees_count }}</span></td>
                <td>
                  <div class="btn-group">
                    <a href="#ModalEdit" class="btn btn-warning btn-xs" title="Edit" data-bs-toggle="modal" data-bs-target="#ModalEdit"
                       onclick="editShift('{{ $shift->shift_id }}', '{{ $shift->shift_name }}', '{{ $shift->time_in }}', '{{ $shift->time_out }}')">
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

<!-- Modal Edit -->
<div class="modal fade" id="ModalEdit" tabindex="-1" aria-labelledby="ModalEditTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="ModalEditTitle">Edit Data Shift</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
      </div>
      <form class="form update-shift" method="post">
        @csrf
        <input type="hidden" name="id" id="txtid" required readonly>
        <div class="modal-body">
          <div class="form-group">
            <label>Nama Shift</label>
            <input type="text" class="form-control" id="txtname" name="shift_name" required>
          </div>
          <div class="form-group">
            <label>Waktu Masuk</label>
            <div class="input-group">
              <input type="text" name="time_in" id="txtin" class="form-control timepicker" required>
              <div class="input-group-text">
                <i class="fa fa-clock-o"></i>
              </div>
            </div>
          </div>
          <div class="form-group">
            <label>Waktu Pulang</label>
            <div class="input-group">
              <input type="text" name="time_out" id="txtout" class="form-control timepicker" required>
              <div class="input-group-text">
                <i class="fa fa-clock-o"></i>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Simpan</button>
          <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><i class="fa fa-remove"></i> Batal</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{ asset('assets/plugins/timepicker/bootstrap-timepicker.min.js') }}"></script>
<script>
  var shiftStoreUrl = "{{ route('shift.store') }}";
  var shiftUpdateUrl = "{{ route('shift.update', '') }}";
  var shiftDeleteUrl = "{{ route('shift.destroy', '') }}";

  $(document).ready(function () {
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    // Timepicker initialization
    $('.timepicker').timepicker({
      showInputs: false,
      showMeridian: false,
      use24hours: true,
      format: 'HH:mm'
    });

    // Add Shift
    $('.add-shift').submit(function (e) {
      e.preventDefault();
      let $form = $(this);
      let isValid = true;

      $form.find('input').each(function () {
        if ($(this).val().trim() === '') {
          isValid = false;
          swal({ title: 'Oops!', text: 'Harap semua bidang inputan diisi!', icon: 'error', timer: 1500 });
          return false;
        }
      });

      if (!isValid) return;

      $.ajax({
        url: shiftStoreUrl,
        type: 'POST',
        data: new FormData(this),
        processData: false,
        contentType: false,
        cache: false,
        beforeSend: function () {
          $form.find('button[type="submit"]').prop('disabled', true);
        },
        success: function (response) {
          if (response === 'success') {
            swal({ title: 'Berhasil!', text: 'Data Shift berhasil disimpan!', icon: 'success', timer: 1500 });
            $('#modalAdd').modal('hide');
            setTimeout(function () {
              location.reload();
            }, 1500);
          } else {
            swal({ title: 'Oops!', text: response, icon: 'error', timer: 1500 });
          }
        },
        complete: function () {
          $form.find('button[type="submit"]').prop('disabled', false);
        }
      });
    });

    // Edit Shift
    $('.update-shift').submit(function (e) {
      e.preventDefault();
      let formData = new FormData(this);
      formData.append('_method', 'PUT');

      $.ajax({
        url: shiftUpdateUrl + '/' + $('#txtid').val(),
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        cache: false,
        success: function (response) {
          if (response === 'success') {
            swal({ title: 'Berhasil!', text: 'Data Shift berhasil diupdate!', icon: 'success', timer: 1500 });
            $('#ModalEdit').modal('hide');
            setTimeout(function () {
              location.reload();
            }, 1500);
          } else {
            swal({ title: 'Oops!', text: response, icon: 'error', timer: 1500 });
          }
        }
      });
    });

    // Delete Shift
    $(document).on('click', '.delete', function () {
      let id = $(this).data('id');

      swal({
        text: "Anda yakin ingin menghapus data ini?",
        icon: "warning",
        buttons: {
          cancel: true,
          confirm: true
        }
      }).then((willDelete) => {
        if (willDelete) {
          $.ajax({
            url: shiftDeleteUrl + '/' + id,
            type: 'DELETE',
            success: function (response) {
              if (response === 'success') {
                swal({ title: 'Berhasil!', text: 'Data berhasil dihapus!', icon: 'success', timer: 1500 });
                setTimeout(function () {
                  location.reload();
                }, 1500);
              } else {
                swal({ title: 'Oops!', text: response, icon: 'error', timer: 1500 });
              }
            }
          });
        }
      });
    });
  });

  function editShift(id, name, timeIn, timeOut) {
    $('#txtid').val(id);
    $('#txtname').val(name);
    $('#txtin').val(timeIn);
    $('#txtout').val(timeOut);
  }
</script>
@endsection

@push('plugin-scripts')
  <script src="{{ asset('assets/plugins/datatables-net/jquery.dataTables.js') }}"></script>
  <script src="{{ asset('assets/plugins/datatables-net-bs5/dataTables.bootstrap5.js') }}"></script>
@endpush

@push('custom-scripts')
  <script src="{{ asset('assets/js/data-table.js') }}"></script>
@endpush
