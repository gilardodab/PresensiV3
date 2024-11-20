@extends('layouts.masteradmin')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/flatpickr/flatpickr.min.css') }}" rel="stylesheet" />
@endpush

@section('content')
<div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
  <div>
    <h4 class="mb-3 mb-md-0" style="align-items: center">Selamat Datang di Dashboard YOFA GROUP</h4>
  </div>
  <div class="d-flex align-items-center flex-wrap text-nowrap">
    <h5>{{format_hari_tanggal($date)}}</h5>
    {{-- <div class="input-group flatpickr wd-200 me-2 mb-2 mb-md-0" id="dashboardDate">
      <span class="input-group-text input-group-addon bg-transparent border-primary" data-toggle><i data-feather="calendar" class="text-primary"></i></span>
      <input type="text" class="form-control bg-transparent border-primary" placeholder="Select date" data-input>
    </div>
    <button type="button" class="btn btn-outline-primary btn-icon-text me-2 mb-2 mb-md-0">
      <i class="btn-icon-prepend" data-feather="printer"></i>
      Print
    </button> --}}
  </div>
</div>

<div class="row">
  <div class="col-12 col-md-6 col-lg-3 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-baseline">
          <h6 class="card-title mb-0">Karyawan</h6>
          <div class="dropdown mb-2">
            <button class="btn btn-link p-0" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
            </button>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <h3 class="mb-2">{{ $employeeCount }}</h3>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-12 col-md-6 col-lg-3 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-baseline">
          <h6 class="card-title mb-0">Total Presensi</h6>
          <div class="dropdown mb-2">
            <button class="btn btn-link p-0" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
              <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-feather="eye" class="icon-sm me-2"></i> <span class="">View</span></a>
              <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-feather="edit-2" class="icon-sm me-2"></i> <span class="">Edit</span></a>
              <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-feather="trash" class="icon-sm me-2"></i> <span class="">Delete</span></a>
              <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-feather="printer" class="icon-sm me-2"></i> <span class="">Print</span></a>
              <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-feather="download" class="icon-sm me-2"></i> <span class="">Download</span></a>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <h3 class="mb-2">{{ $positionCount }}</h3>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-12 col-md-6 col-lg-3 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-baseline">
          <h6 class="card-title mb-0">Total Kunjungan</h6>
          <div class="dropdown mb-2">
            <button class="btn btn-link p-0" type="button" id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
              <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-feather="eye" class="icon-sm me-2"></i> <span class="">View</span></a>
              <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-feather="edit-2" class="icon-sm me-2"></i> <span class="">Edit</span></a>
              <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-feather="trash" class="icon-sm me-2"></i> <span class="">Delete</span></a>
              <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-feather="printer" class="icon-sm me-2"></i> <span class="">Print</span></a>
              <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-feather="download" class="icon-sm me-2"></i> <span class="">Download</span></a>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <h3 class="mb-2">{{ $shiftCount }}</h3>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-12 col-md-6 col-lg-3 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-baseline">
          <h6 class="card-title mb-0">Jam Kerja</h6>
          <div class="dropdown mb-2">
            <button class="btn btn-link p-0" type="button" id="dropdownMenuButton3" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton3">
              <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-feather="eye" class="icon-sm me-2"></i> <span class="">View</span></a>
              <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-feather="edit-2" class="icon-sm me-2"></i> <span class="">Edit</span></a>
              <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-feather="trash" class="icon-sm me-2"></i> <span class="">Delete</span></a>
              <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-feather="printer" class="icon-sm me-2"></i> <span class="">Print</span></a>
              <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-feather="download" class="icon-sm me-2"></i> <span class="">Download</span></a>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <h3 class="mb-2">{{ $shiftCount }}</h3>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-12 col-xl-12 grid-margin stretch-card">
    <div class="card overflow-hidden">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-baseline mb-4 mb-md-3">
          <h6 class="card-title mb-0">Statistik Presensi Harian</h6>
          <div class="dropdown">
            <button class="btn btn-link p-0" type="button" id="dropdownMenuButton3" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton3">
              <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-feather="eye" class="icon-sm me-2"></i> <span class="">View</span></a>
              <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-feather="edit-2" class="icon-sm me-2"></i> <span class="">Edit</span></a>
              <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-feather="trash" class="icon-sm me-2"></i> <span class="">Delete</span></a>
              <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-feather="printer" class="icon-sm me-2"></i> <span class="">Print</span></a>
              <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-feather="download" class="icon-sm me-2"></i> <span class="">Download</span></a>
            </div>
          </div>
        </div>
        <div class="row align-items-start mb-2">
        </div>
        <div class="chart">
          <canvas id="areaChart" style="height:100px"></canvas>
      </div>
      </div>
    </div>
  </div>
</div> <!-- row -->


<div class="row">
  <div class="col-12 col-md-6 col-lg-6 col-xl-6 stretch-card mb-4">
    <div class="card">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-baseline mb-2">
          <h6 class="card-title mb-0">Daftar Presensi Hari Ini</h6>
          <div class="dropdown mb-2">
            <button class="btn btn-link p-0" type="button" id="dropdownMenuButton7" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton7">
              <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-feather="eye" class="icon-sm me-2"></i> <span class="">View</span></a>
              <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-feather="edit-2" class="icon-sm me-2"></i> <span class="">Edit</span></a>
              <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-feather="trash" class="icon-sm me-2"></i> <span class="">Delete</span></a>
              <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-feather="printer" class="icon-sm me-2"></i> <span class="">Print</span></a>
              <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-feather="download" class="icon-sm me-2"></i> <span class="">Download</span></a>
            </div>
          </div>
        </div>
        <div class="table-responsive">
          <table class="table table-hover mb-0">
            <thead>
              <tr>
                <th style="width: 10px" class="text-center">No.</th>
                <th>Nama</th>
                <th>Masuk</th>
                <th class="text-right">Pulang</th>
              </tr>
            </thead>
            <tbody>
              @forelse ($absentDay as $index => $absent)
              <tr>
                  <td class="text-center">{{ $index + 1 }}</td>
                  <td>{{ $absent->employee['employees_name'] }}</td>
                  <td>{{ $absent['time_in'] }}</td>
                  <td>{{ $absent['time_out'] }}</td>
                  {{-- <td class="text-right">
                      <a href="{{ url('absensi?op=views&id=' . $absent['employees_id']) }}" class="btn btn-warning btn-xs">
                          <i class="fa fa-external-link-square" aria-hidden="true"></i>
                      </a>
                  </td> --}}
              </tr>
              @empty
              <tr>
                  <td colspan="4" class="text-center">Tidak ada data absensi hari ini</td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <div class="col-12 col-md-6 col-lg-6 col-xl-6 stretch-card mb-4">
    <div class="card">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-baseline mb-2">
          <h6 class="card-title mb-0">Daftar Pengajuan Cuti Karyawan</h6>
          <div class="dropdown mb-2">
            <button class="btn btn-link p-0" type="button" id="dropdownMenuButton8" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton8">
              <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-feather="eye" class="icon-sm me-2"></i> <span class="">View</span></a>
              <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-feather="edit-2" class="icon-sm me-2"></i> <span class="">Edit</span></a>
              <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-feather="trash" class="icon-sm me-2"></i> <span class="">Delete</span></a>
              <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-feather="printer" class="icon-sm me-2"></i> <span class="">Print</span></a>
              <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-feather="download" class="icon-sm me-2"></i> <span class="">Download</span></a>
            </div>
          </div>
        </div>
        <div class="table-responsive">
          <table class="table table-hover mb-0">
            <thead>
              <tr>
                <th style="width: 10px" class="text-center">No.</th>
                <th>Nama</th>
                <th>Tanggal Cuti</th>
                <th class="text-center">Jumlah</th>
                <th class="text-right">Masuk Kerja</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($cutyRequests as $index => $cuty)
              <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $cuty->employees['employees_name'] }}</td>
                <td>{{ tgl_ind($cuty['cuty_start']) }} s/d {{ tgl_ind($cuty['cuty_end']) }}</td>
                <td class="text-center">{{ $cuty['cuty_total'] }}</td>
                <td class="text-right"><span class="badge bg-danger">{{ tgl_ind($cuty['date_work']) }}</span></td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div> <!-- row -->
@php
    $date = date("d-m-Y", strtotime("-6 days"));
    $D = substr($date, 0, 2);
    $M = substr($date, 3, 2) - 1;
    $Y = substr($date, 6, 4);
    $tgl_skrg = date("Y-m-d");
    $seminggu = strtotime("-1 week +1 day", strtotime($tgl_skrg));
    $hasilnya = date('Y-m-d', $seminggu);
    $tanggal_visitor = [];
    $absensi = [];

    for ($i = 0; $i <= 6; $i++) {
        $tgl_pengujung = strtotime("+$i day", strtotime($hasilnya));
        $hasil_pengujung = date("Y-m-d", $tgl_pengujung);
        $tanggal_visitor[] = tgl_ind($hasil_pengujung);
        $result_absensi = DB::table('presence')->where('presence_date', $hasil_pengujung)->count();
        $absensi[] = $result_absensi;
    }
    $tanggal_visitor = implode('","', $tanggal_visitor);
@endphp

<script type="text/javascript">
    var lineChartData = {
      labels: ["{!! $tanggal_visitor !!}"],
      datasets: [
        {
          label: "Statistik Absensi",
          fillColor: "rgba(29,75,251,0.7)",
          strokeColor: "rgba(220,220,220,1)",
          pointColor: "rgba(220,220,220,1)",
          pointStrokeColor: "#fff",
          pointHighlightFill: "#fff",
          pointHighlightStroke: "rgba(220,220,220,1)",
          data: {!! json_encode($absensi) !!}
        }
      ]
    };

    window.onload = function() {
        var ctx = document.getElementById("areaChart").getContext("2d");
        new Chart(ctx).Line(lineChartData, {
            responsive: true
        });
    }
</script>
@endsection

@push('plugin-scripts')
  <script src="{{ asset('assets/plugins/flatpickr/flatpickr.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/apexcharts/apexcharts.min.js') }}"></script>
@endpush

@push('custom-scripts')
  <script src="{{ asset('assets/js/dashboard.js') }}"></script>
 
@endpush