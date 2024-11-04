@extends('layouts.masteradmin') <!-- Pastikan Anda menggunakan layout yang sesuai -->

@section('content')
<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <!-- Karyawan Box -->
            <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-aqua">
                    <div class="inner">
                      <h3>{{ $employeeCount }}</h3>
                        <p>Karyawan</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-user"></i>
                    </div>
                    <a href="{{ url('karyawan') }}" class="small-box-footer">
                        More info <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

            <!-- Jabatan Box -->
            <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-yellow">
                    <div class="inner">
                        <h3>{{ $positionCount }}</h3>
                        <p>Jabatan</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-briefcase"></i>
                    </div>
                    <a href="{{ url('/jabatan') }}" class="small-box-footer">
                        More info <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

            <!-- Lokasi Kantor Box -->
            <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-red">
                    <div class="inner">
                        <h3>{{ $buildingCount }}</h3>
                        <p>Lokasi Kantor</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-building"></i>
                    </div>
                    <a href="{{ url('kantor') }}" class="small-box-footer">
                        More info <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

            <!-- Jam Kerja Box -->
            <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3>{{ $shiftCount }}</h3>
                        <p>Jam Kerja</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-retweet"></i>
                    </div>
                    <a href="{{ url('shift') }}" class="small-box-footer">
                        More Info <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            
            <!-- Statistik Absensi -->
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="box box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">Statistik Absensi</h3>
                    </div>
                    <div class="box-body">
                        <div class="chart">
                            <canvas id="areaChart" style="height:300px"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Absensi Hari Ini -->
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                <div class="box box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">Absensi Hari Ini</h3>
                    </div>
                    <div class="box-body no-padding">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <th style="width: 10px" class="text-center">No.</th>
                                    <th>Nama</th>
                                    <th>Jam Masuk</th>
                                    <th>Jam Pulang</th>
                                    <th class="text-right">Aksi</th>
                                </tr>
                                @foreach ($absentDay as $index => $absent)
                                <tr>
                                    <td class="text-center">{{ $index + 1 }}</td>
                                    <td>{{ $absent->employee['employees_name'] }}</td>
                                    <td>{{ $absent['time_in'] }}</td>
                                    <td>{{ $absent['time_out'] }}</td>
                                    <td class="text-right">
                                        <a href="{{ url('absensi?op=views&id=' . $absent['employees_id']) }}" class="btn btn-warning btn-xs">
                                            <i class="fa fa-external-link-square" aria-hidden="true"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Permohonan Cuti -->
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                <div class="box box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">Permohonan Cuti</h3>
                        <div class="box-tools pull-right">
                            <a href="{{ url('cutyadmin') }}" class="btn btn-success btn-flat">Data Cuti</a>
                        </div>
                    </div>
                    <div class="box-body no-padding">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <th style="width: 10px" class="text-center">No.</th>
                                    <th>Nama</th>
                                    <th>Tanggal Cuti</th>
                                    <th class="text-center">Jumlah</th>
                                    <th class="text-right">Masuk Kerja</th>
                                </tr>
                                @foreach ($cutyRequests as $index => $cuty)
                                <tr>
                                    <td class="text-center">{{ $index + 1 }}</td>
                                    <td>{{ $cuty->employees['employees_name'] }}</td>
                                    <td>{{ tgl_ind($cuty['cuty_start']) }} sampai {{ tgl_ind($cuty['cuty_end']) }}</td>
                                    <td class="text-center">
                                        <label class="label label-warning">{{ $cuty['cuty_total'] }}</label>
                                    </td>
                                    <td class="text-right">{{ tgl_ind($cuty['date_work']) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

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
