@extends('layouts.app')

@section('content')

  <!-- App Capsule -->
  <div id="appCapsule">
      <!-- Wallet Card -->

      <div class="section wallet-card-section pt-1">
          <div class="wallet-card">
              <!-- Balance -->
              <div class="balance">
                  <div class="left">
                      <span class="title">Selamat {{ $salam_info['salam'] }}</span>
                      <h1 class="total"> {{ Auth::user()->employees_name }}</h1>
                  </div>
              </div>
              <!-- * Balance -->
              
              <!-- Wallet Footer -->
              <div class="wallet-footer">
                  <div class="item">
                      <a href="./absent">
                          <div class="icon-wrapper bg-danger">
                              <ion-icon name="camera-outline"></ion-icon>
                          </div>
                          <strong>Absen Kantor</strong>
                      </a>
                  </div>
                  <div class="item">
                      <a href="./absenkunjungan">
                          <div class="icon-wrapper bg-purle">
                              <ion-icon name="camera-outline"></ion-icon>
                          </div>
                          <strong>Kunjungan</strong>
                      </a>
                  </div>

                  <div class="item">
                      <a href="./cuty">
                          <div class="icon-wrapper bg-primary">
                              <ion-icon name="calendar-outline"></ion-icon>
                          </div>
                          <strong>Cuti</strong>
                      </a>
                  </div>

                  <div class="item">
                      <a href="./history">
                          <div class="icon-wrapper bg-success">
                              <ion-icon name="document-text-outline"></ion-icon>
                          </div>
                          <strong>History</strong>
                      </a>
                  </div>

                  <div class="item">
                      <a href="./profile">
                          <div class="icon-wrapper bg-warning">
                              <ion-icon name="person-outline"></ion-icon>
                          </div>
                          <strong>Profil</strong>
                      </a>
                  </div>
              </div>
              <!-- * Wallet Footer -->
          </div>
      </div>
      <!-- Wallet Card -->

      <!-- Label Absensi Hari ini -->
      <div class="section">
        <div class="row mt-2">
            @if($presences->isNotEmpty())
                @foreach($presences as $presence)
                    <!-- Menampilkan Absen Masuk -->
                    <div class="col-6">
                        <div class="stat-box bg-danger">
                            <div class="title text-white">Presensi Masuk</div>
                            <div class="value text-white">{{ $presence->time_in }}</div>
                        </div>
                    </div>
    
                    <!-- Cek apakah sudah absen pulang -->
                    @if($presence->time_out == '00:00:00' || is_null($presence->time_out))
                        <div class="col-6">
                            <a href="{{ url('/absent') }}">
                                <div class="stat-box bg-success">
                                    <div class="title text-white">Presesni Pulang</div>
                                    <div class="value text-white">Belum Presensi</div>
                                </div>
                            </a>
                        </div>
                    @else
                        <div class="col-6">
                            <div class="stat-box bg-success">
                                <div class="title text-white">Presensi Pulang</div>
                                <div class="value text-white">{{ $presence->time_out }}</div>
                            </div>
                        </div>
                    @endif
                @endforeach
            @else
                <!-- Jika belum absen masuk -->
                <div class="col-6">
                    <a href="{{ url('/absent') }}">
                        <div class="stat-box bg-danger">
                            <div class="title text-white">Presensi Masuk</div>
                            <div class="value text-white">Belum Presensi</div>
                        </div>
                    </a>
                </div>
    
                <!-- Absen Pulang belum dilakukan -->
                <div class="col-6">
                    <div class="stat-box bg-secondary">
                        <div class="title text-white">Presensi Pulang</div>
                        <div class="value text-white">Belum Presensi</div>
                    </div>
                </div>
            @endif 
        </div>
    </div>
    
    
    

      <!-- Absensi Bulan Ini -->
        <!-- resources/views/your_view.blade.php -->
        <div class="section mt-4">
            <div class="section-title mb-1">
                Absensi Bulan
                <select class="select select-change text-primary" required>
                    @foreach (range(1, 12) as $i)
                        @php
                            $monthNum = str_pad($i, 2, '0', STR_PAD_LEFT); // format bulan
                            $monthName = DateTime::createFromFormat('!m', $monthNum)->format('F'); // nama bulan
                        @endphp
                        <option value="{{ $monthNum }}" {{ $month == $i ? 'selected' : '' }}>
                            {{ getIndonesianMonthName($i) }}
                        </option>
                    @endforeach
                </select>
                <span class="text-primary">{{ $year }}</span>
            </div>
            <div class="transactions">
                <div class="row">
                    <div class="load-home" style="display:contents"></div>   
                </div>
            </div>
        </div>


      <!-- 1 Minggu Terakhir -->
      <div class="section mt-2 mb-2">
          <div class="section-title">1 Minggu Terakhir</div>
          <div class="card">
              <div class="table-responsive">
                  <table class="table table-dark rounded bg-purple">
                      <thead>
                          <tr>
                              <th scope="col">Tanggal</th>
                              <th scope="col">Jam Masuk</th>
                              <th scope="col">Jam Pulang</th>
                          </tr>
                      </thead>
                      <tbody>

            
                        @foreach($attendances as $row_absen)
                            <tr>
                                <!-- Menampilkan data tanggal menggunakan fungsi tgl_ind untuk format tanggal -->
                                <th scope="row">{{ tgl_ind($row_absen->presence_date) }}</th>
                                <!-- Menampilkan waktu masuk (time_in) -->
                                <td>{{ $row_absen->time_in }}</td>
                                <!-- Menampilkan waktu keluar (time_out) -->
                                <td>
                                @if($row_absen->time_out === '00:00:00')
                                    Belum Presensi
                                @else
                                    {{ $row_absen->time_out }}
                                @endif
                            </td>
                            </tr>
                        @endforeach
                    

                      </tbody>
                  </table>
              </div>
          </div>
      </div>   
  </div>
  {{-- <script>
    var loadhomeUrl = "{{ route('load.home.counter') }}";
</script>
<script src="{{ asset('assets/js/script.js') }}"></script> --}}
@endsection




