@extends('layouts.masteradmin') <!-- Atau layout yang sesuai -->
@push('plugin-styles')
  <link href="{{ asset('assets/plugins/datatables-net-bs5/dataTables.bootstrap5.css') }}" rel="stylesheet" />
@endpush

@section('content')
<nav class="page-breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
    <li class="breadcrumb-item active" aria-current="page">Data Presensi Harian</li>
  </ol>
</nav>

<div class="row">
  <div class="col-md-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h6 class="card-title">Data Presensi Harian</h6>
        <div class="row mb-3">
          <div class="col-6">
            <select class="form-select" id="selectEmployee">
              <option value="">Semua Karyawan</option>
              @foreach ($employees as $employee)
                <option value="{{ $employee->id }}">{{ $employee->employees_name }}</option>
              @endforeach
            </select>
          </div>
          <div class="col-6">
            <select class="form-select" id="selectPosition">
              <option value="">Semua Divisi</option>
              @foreach ($positions as $position)
                <option value="{{ $position->position_id }}">{{ $position->position_name }}</option>
              @endforeach
            </select>
          </div>
        </div>
        <div class="row mb-3">
          <div class="col-6">
            <input type="text" class="form-control" name="daterange" placeholder="Pilih Rentang Tanggal" />
          </div>
          <div class="col-6">
            <button type="button" class="btn btn-danger btn-sm btn-clear"><i class="fa fa-refresh"></i> Refresh</button>
            <button type="button" class="btn btn-primary btn-sm btn-print"><i class="fa fa-print"></i> Print</button>
          </div>
        </div>
        <div class="loaddata"></div>
      </div>
    </div>
  </div>
</div>
@endsection

@push('plugin-scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@endpush

@push('custom-scripts')
<script>
$(document).ready(function() {
    // Initialize the date range picker
    $('input[name="daterange"]').daterangepicker({
        opens: 'left',
        autoUpdateInput: false,
        locale: {
            cancelLabel: 'Clear',
            format: 'YYYY-MM-DD'
        }
    });

    $('input[name="daterange"]').on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format('YYYY-MM-DD'));
        triggerFilter();
    });

    $('input[name="daterange"]').on('cancel.daterangepicker', function(ev, picker) {
        $(this).val('');
        triggerFilter();
    });

    // Event listeners for the select elements to trigger the filter on change
    $('#selectEmployee').on('change', function() {
        triggerFilter();
    });

    $('#selectPosition').on('change', function() {
        triggerFilter();
    });

    // Function to handle the AJAX request for filtering data
    function triggerFilter() {
        var employee = $('#selectEmployee').val();
        var position = $('#selectPosition').val();
        var dateRange = $('input[name="daterange"]').val();
        var startDate, endDate;

        if (dateRange) {
            [startDate, endDate] = dateRange.split(' - ');
        } else {
            // Set default to the current month's start date and today's date
            var currentDate = new Date();
            startDate = new Date(currentDate.getFullYear(), currentDate.getMonth(), 1).toISOString().split('T')[0];
            endDate = currentDate.toISOString().split('T')[0];
        }
        console.log(employee, position, startDate, endDate);
        
        $.ajax({
            url: '{{ route('absensi.load') }}',
            method: 'GET',
            data: {
                id: employee,
                position: position,
                start_date: startDate,
                end_date: endDate,
                _token: '{{ csrf_token() }}'
            },
            success: function(data) {
                $('.loaddata').html(data);
            },
            error: function(xhr, status, error) {
                console.error("Error: " + error);
                alert("Terjadi kesalahan: " + xhr.responseText);
            }
        });
    }

    $('.btn-clear').click(function(e) {
        $('input[name="daterange"]').val('');
        $('#selectEmployee').val('');
        $('#selectPosition').val('');
        loadData();
    });

    function loadData() {
        $.ajax({
            url: '{{ route('absensi.load') }}',
            method: 'GET',
            success: function(data) {
                $('.loaddata').html(data);
            }
        });
    }

    loadData(); // Initial load

    $(document).on('click', '.btn-modal', function(e) {
        e.preventDefault();
        var latitude = $(this).data('latitude');
        var longitude = $(this).data('longitude');
        var name = $(this).closest('tr').find('td:nth-child(2)').text(); // Get the name from the row

        if (latitude && longitude) {
            $(".modal-title-name").html(name);
            $("#iframe-map").html('<iframe src="https://www.google.com/maps?q=' + latitude + ',' + longitude + '&output=embed" frameborder="0" width="100%" height="400px" marginwidth="0" marginheight="0" scrolling="no"></iframe>');
            $('#modal-location').modal('show');
        } else {
            swal({title: 'Oops!', text: 'Data Lokasi tidak ditemukan', icon: 'error', timer: 2000,});
        }
    });

});

</script>
@endpush
