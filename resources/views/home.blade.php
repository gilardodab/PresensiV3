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
                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24"><g fill="none" stroke="white" stroke-width="2"><circle cx="12" cy="13" r="3"/><path d="M9.778 21h4.444c3.121 0 4.682 0 5.803-.735a4.4 4.4 0 0 0 1.226-1.204c.749-1.1.749-2.633.749-5.697s0-4.597-.749-5.697a4.4 4.4 0 0 0-1.226-1.204c-.72-.473-1.622-.642-3.003-.702c-.659 0-1.226-.49-1.355-1.125A2.064 2.064 0 0 0 13.634 3h-3.268c-.988 0-1.839.685-2.033 1.636c-.129.635-.696 1.125-1.355 1.125c-1.38.06-2.282.23-3.003.702A4.4 4.4 0 0 0 2.75 7.667C2 8.767 2 10.299 2 13.364s0 4.596.749 5.697c.324.476.74.885 1.226 1.204C5.096 21 6.657 21 9.778 21Z"/><path stroke-linecap="round" d="M19 10h-1"/></g></svg>
                          </div>
                          <strong>Absen Kantor</strong>
                      </a>
                  </div>
                  <div class="item">
                      <a href="./kunjungan">
                          <div class="icon-wrapper bg-purle">
                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24"><path fill="white" d="M5.25 3.5A1.75 1.75 0 0 0 3.5 5.25v3a.75.75 0 0 1-1.5 0v-3A3.25 3.25 0 0 1 5.25 2h3a.75.75 0 0 1 0 1.5zm0 17a1.75 1.75 0 0 1-1.75-1.75v-3a.75.75 0 0 0-1.5 0v3A3.25 3.25 0 0 0 5.25 22h3a.75.75 0 0 0 .707-1l-.005-.015a.75.75 0 0 0-.702-.485zM20.5 5.25a1.75 1.75 0 0 0-1.75-1.75h-3a.75.75 0 0 1 0-1.5h3A3.25 3.25 0 0 1 22 5.25v3a.75.75 0 0 1-1.5 0zM18.75 20.5a1.75 1.75 0 0 0 1.75-1.75v-3a.75.75 0 0 1 1.5 0v3A3.25 3.25 0 0 1 18.75 22h-3a.75.75 0 0 1 0-1.5zM6.5 18.616q0 .465.258.884H5.25a1 1 0 0 1-.129-.011A3.1 3.1 0 0 1 5 18.616v-.366A2.25 2.25 0 0 1 7.25 16h9.5A2.25 2.25 0 0 1 19 18.25v.366c0 .31-.047.601-.132.875a1 1 0 0 1-.118.009h-1.543a1.56 1.56 0 0 0 .293-.884v-.366a.75.75 0 0 0-.75-.75h-9.5a.75.75 0 0 0-.75.75zm8.25-8.866a2.75 2.75 0 1 0-5.5 0a2.75 2.75 0 0 0 5.5 0m1.5 0a4.25 4.25 0 1 1-8.5 0a4.25 4.25 0 0 1 8.5 0"/></svg>
                          </div>
                          <strong>Kunjungan</strong>
                      </a>
                  </div>

                  <div class="item">
                      <a href="./cuty">
                          <div class="icon-wrapper bg-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 512 512"><rect width="416" height="384" x="48" y="80" fill="none" stroke="white" stroke-linejoin="round" stroke-width="32" rx="48"/><circle cx="296" cy="232" r="24" fill="white"/><circle cx="376" cy="232" r="24" fill="white"/><circle cx="296" cy="312" r="24" fill="white"/><circle cx="376" cy="312" r="24" fill="white"/><circle cx="136" cy="312" r="24" fill="white"/><circle cx="216" cy="312" r="24" fill="white"/><circle cx="136" cy="392" r="24" fill="white"/><circle cx="216" cy="392" r="24" fill="white"/><circle cx="296" cy="392" r="24" fill="white"/><path fill="none" stroke="white" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" d="M128 48v32m256-32v32"/><path fill="none" stroke="white" stroke-linejoin="round" stroke-width="32" d="M464 160H48"/></svg>
                          </div>
                          <strong>Cuti</strong>
                      </a>
                  </div>

                  <div class="item">
                      <a href="./callplan">
                          <div class="icon-wrapper bg-warning">
                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24"><path fill="white" d="M12 4a3 3 0 0 0-3 3c0 1.237.782 2.498 1.738 3.544c.456.498.914.908 1.262 1.195a13 13 0 0 0 1.262-1.195C14.218 9.498 15 8.238 15 7a3 3 0 0 0-3-3m0 10.214c-.258-.178-.519-.35-.77-.537a14.6 14.6 0 0 1-1.968-1.784C8.218 10.751 7 9.013 7 7a5 5 0 0 1 10 0c0 2.012-1.218 3.752-2.262 4.893a14.6 14.6 0 0 1-1.968 1.784c-.251.187-.512.36-.77.537m0-6.964a.25.25 0 1 0 0-.5a.25.25 0 0 0 0 .5M10.25 7a1.75 1.75 0 1 1 3.5 0a1.75 1.75 0 0 1-3.5 0M2 10h3v2h-.634l.868 1.419L4 14.174V20h16v-6.248l-.783-1.035l.68-.514l.103.137V12h-2v-2h4v12H2zm2 2.194L4.317 12H4zm14.654 3.607l-.879.478q-.663.36-1.366.635l-.728-1.863q.585-.228 1.139-.53l.878-.477zm-11.318.974a12 12 0 0 1-1.346-.677l1.008-1.727q.543.317 1.123.564l.92.392l-.785 1.84zm6.303.897l-.999.05q-.753.037-1.507-.02l.152-1.994q.627.048 1.255.016l1-.05z"/></svg>
                          </div>
                          <strong>Callplan</strong>
                      </a>
                  </div>
              </div>
              <!-- * Wallet Footer -->
              <div class="wallet-footer" style="border-top: 0px solid #e0e0e0;">
                <div class="item">
                    <a href="./scan">
                        <div class="icon-wrapper bg-dark">
                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 512 512"><rect width="80" height="80" x="336" y="336" fill="white" rx="8" ry="8"/><rect width="64" height="64" x="272" y="272" fill="white" rx="8" ry="8"/><rect width="64" height="64" x="416" y="416" fill="white" rx="8" ry="8"/><rect width="48" height="48" x="432" y="272" fill="white" rx="8" ry="8"/><rect width="48" height="48" x="272" y="432" fill="white" rx="8" ry="8"/><rect width="80" height="80" x="336" y="96" fill="white" rx="8" ry="8"/><rect width="176" height="176" x="288" y="48" fill="none" stroke="white" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" rx="16" ry="16"/><rect width="80" height="80" x="96" y="96" fill="white" rx="8" ry="8"/><rect width="176" height="176" x="48" y="48" fill="none" stroke="white" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" rx="16" ry="16"/><rect width="80" height="80" x="96" y="336" fill="white" rx="8" ry="8"/><rect width="176" height="176" x="48" y="288" fill="none" stroke="white" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" rx="16" ry="16"/></svg>
                        </div>
                        <strong>Scan Alat</strong>
                    </a>
                </div>
                <div class="item">
                    <a href="./history">
                        <div class="icon-wrapper bg-success">
                          <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24"><g fill="none" stroke="white" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"><path d="M8 5H6a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h5.697M18 14v4h4m-4-7V7a2 2 0 0 0-2-2h-2"/><path d="M8 5a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2v0a2 2 0 0 1-2 2h-2a2 2 0 0 1-2-2m6 13a4 4 0 1 0 8 0a4 4 0 1 0-8 0m-6-7h4m-4 4h3"/></g></svg>
                        </div>
                        <strong>Riwayat</strong>
                    </a>
                </div>
                {{-- <div class="item">
                    <a href="./profile">
                        <div class="icon-wrapper bg-warning">
                          <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 512 512"><path fill="none" stroke="white" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" d="M344 144c-3.92 52.87-44 96-88 96s-84.15-43.12-88-96c-4-55 35-96 88-96s92 42 88 96"/><path fill="none" stroke="white" stroke-miterlimit="10" stroke-width="32" d="M256 304c-87 0-175.3 48-191.64 138.6C62.39 453.52 68.57 464 80 464h352c11.44 0 17.62-10.48 15.65-21.4C431.3 352 343 304 256 304Z"/></svg>
                        </div>
                        <strong>Profil</strong>
                    </a>
                </div> --}}
            </div>
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
                        <div class="stat-box bg-purle">
                            <div class="title text-white">Presensi Masuk</div>
                            <div class="value text-white">{{ $presence->time_in }}</div>
                        </div>
                    </div>
    
                    <!-- Cek apakah sudah absen pulang -->
                    @if($presence->time_out == '00:00:00' || is_null($presence->time_out))
                        <div class="col-6">
                            <a href="{{ url('/absent') }}">
                                <div class="stat-box bg-success">
                                    <div class="title text-white">Presensi Pulang</div>
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
                        <div class="stat-box bg-purle">
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
                Presensi Bulan
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

@endsection




