
<div class="table-responsive">
    <table class="table table-bordered table-hover" id="swdatatable">
        <thead>
            <tr>
                <th class="align-middle" width="20">No</th>
                <th class="align-middle">Tanggal</th>
                <th class="align-middle text-center">Scan Masuk</th>
                <th class="align-middle">Status</th>
                <th class="align-middle text-right">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @php
                $hari = date("d");
                $bulan = date ("m");
                $tahun = date("Y");
                $jumlahHari = date("t", mktime(0,0,0,$bulan,$hari,$tahun));
            @endphp
            @for ($d = 1; $d <= $jumlahHari; $d++)

                @php
                    $status_hadir = 'Tidak Hadir'; // Default status
                    $background = '';
                    $warna = '';
                    $date_month_year = $tahun . '-' . $bulan . '-' . $d;
                    $presence = $presences->firstWhere('presence_date', $date_month_year);
                    
                    // Set status dan warna untuk hari minggu
                    if (date('l', mktime(0, 0, 0, $bulan, $d, $tahun)) == "Sunday") {
                        $warna = '#ffffff';
                        $background = '#FF0000'; // Red background for Sundays
                        $status_hadir = 'Libur Akhir Pekan';
                    }

                    $status_time_in = $presence && $presence->time_in > $shift->time_in ? 'Terlambat' : 'Tepat Waktu';

                @endphp
                
                <tr style="background-color: {{ $background }}; color: {{ $warna }};">
                    <td class="text-center">{{ $d }}</td>
                    <td>{{ \Carbon\Carbon::parse($date_month_year)->translatedFormat('l, d F Y') }}</td>
                    {{-- <td class="text-center picture">
                        @if($presence && $presence->picture_in)
                            <a class="image-link" href="{{ asset('sw-content/absent/' . $presence->picture_in) }}">
                                <img src="{{ asset('sw-content/absent/' . $presence->picture_in) }}" height="40" width="40">
                            </a>
                        @else
                            <img src="{{ asset('sw-content/avatar.jpg') }}" height="40" width="40">
                        @endif
                    </td> --}}
                    <td class="text-center">{{ $presence->time_in ?? '-' }} {{ $status_time_in }}</td>
                    <td class="text-center">{{ $status_hadir }}</td>
                    <td class="text-right">
                        {{-- Conditionally display buttons based on presence data --}}
                        @if($presence && $presence->latitude_longtitude_in)
                            @php
                                list($latitude, $longitude) = explode(',', $presence->latitude_longtitude_in);
                            @endphp
                            <a href="{{ route('map.show', ['latitude' => $latitude, 'longitude' => $longitude, 'name' => 'Masuk']) }}" class="btn btn-warning btn-xs enable-tooltip" title="Lokasi">
                                <i class="fa fa-map-marker"></i> Masuk
                            </a>
                        @else
                            <p>-</p>
                        @endif
                
                        @if($presence && $presence->latitude_longtitude_out)
                            @php
                                list($latitude_out, $longitude_out) = explode(',', $presence->latitude_longtitude_out);
                            @endphp
                            <a href="{{ route('map.show', ['latitude' => $latitude_out, 'longitude' => $longitude_out, 'name' => 'Pulang']) }}" class="btn btn-warning btn-xs enable-tooltip" title="Lokasi">
                                <i class="fa fa-map-marker"></i> Pulang
                            </a>
                        @else
                            <p>-</p>
                        @endif
                    </td>
                </tr>
            @endfor
        </tbody>
    </table>
</div>

