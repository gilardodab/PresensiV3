@extends('layouts.masteradmin')
@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="/adminyofa">Dashboard</a></li>
      <li class="breadcrumb-item active" aria-current="page">Data Permohonan Cuti</li>
    </ol>
  </nav>
  
  <div class="row">
          <!-- Kode untuk case 'add' -->
    <div class="col-md-12 grid-margin stretch-card">
      <div class="card">
                        <div class="card-body">
                            @if ($user->level == 1)
                            <button type="button" class="btn btn-success btn-flat" data-bs-toggle="modal" data-bs-target="#modalAdd"><i class="fa fa-plus"></i> Tambah Baru</button>
                        @else
                            <button type="button" class="btn btn-success btn-flat access-failed"><i class="fa fa-plus"></i> Tambah Baru</button>
                        @endif
                            <div class="table-responsive">
                                <table id="datatable" class="table table-bordered">
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
                                                        {{-- <button type="button" class="btn btn-warning btn-xs dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Proses
                                                          <span class="caret"></span>
                                                        </button> --}}
                                                        <button class="btn btn-warning btn-xs" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>Proses
                                                          </button>
                                                          <div class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                                            <a class="dropdown-item d-flex align-items-center update-status" data-status="1" data-id="{{$cuti['cuty_id']}}"><i  data-feather="check" class="update-status icon-sm me-2"></i> <span class="">Setujui</span></a>
                                                            <a class="dropdown-item d-flex align-items-center update-status" data-status="2" data-id="{{$cuti['cuty_id']}}"><i data-feather="x" class="update-status icon-sm me-2"></i> <span class="">Tidak disetujui</span></a>
                                                          </div>
                                                        {{-- <ul class="dropdown-menu" role="menu">
                                                          <li><a href="javascript:void(0);" data-id="{{$cuti['cuty_id']}}" data-status="1" class="update-status btn btn-xs btn-success" >Setujui</a></li>
                                                          <li><a href="javascript:void(0);" data-id="{{$cuti['cuty_id']}}" data-status="2" class="update-status btn btn-xs btn-danger">Tidak disetujui</a></li>
                                                        </ul> --}}
                                                      </div>
                                                      <a href="{{ route('cuti.print', $cuti['cuty_id']) }}" target="_blank" class="btn btn-xs btn-danger " title="Print">
                                                        <i class="fa fa-print" aria-hidden="true"></i> Print
                                                    </a>
                                                    
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
@push ('plugin-scripts')
  <script src="{{ asset('assets/plugins/datatables-net/jquery.dataTables.js') }}"></script>
  <script src="{{ asset('assets/plugins/datatables-net-bs5/dataTables.bootstrap5.js') }}"></script>
  <script src=" https://code.jquery.com/jquery-3.6.0.min.js"></script>
@endpush
@push('custom-scripts')
<script src="{{ asset('admin/js/cuti.js') }}"></script>
@endpush
  <script>
    var cutiUpdateUrl = "{{ route('cuti.updateStatus') }}";
  </script> 
  {{-- <script>
    $(document).ready(function() {
    $('#datatable').dataTable({
        "iDisplayLength": 20,
        "aLengthMenu": [[20, 30, 50, -1], [20, 30, 50, "All"]]
    });
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    
    function loading(){
        $(".loading").show();
        $(".loading").delay(1500).fadeOut(500);
    }
    
        /* -------------------- Edit ------------------- */
        $(document).on('click', '.update-status', function() {
            var id = $(this).attr("data-id");
            var status = $(this).attr("data-status");
        
            $.ajax({
                url: cutiUpdateUrl,
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    id: id,
                    status: status
                },
                beforeSend: function() {
                    loading(); // Show loading state
                },
                success: function(response) {
                    if (response.status === 'success') {
                        swal({
                            title: 'Berhasil!',
                            text: response.message,
                            icon: 'success',
                            timer: 2000
                        });
                        setTimeout(function() {
                            location.reload();
                        }, 2100);
                    } else {
                        swal({
                            title: 'Oops!',
                            text: response.message,
                            icon: 'error',
                            timer: 1500
                        });
                    }
                },
                complete: function() {
                    $(".loading").hide();
                },
                error: function(xhr) {
                    swal({
                        title: 'Error!',
                        text: xhr.responseJSON.message,
                        icon: 'error',
                        timer: 1500
                    });
                }
            });
        });
        
    
    });
  </script> --}}

@endsection