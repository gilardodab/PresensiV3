@php
use Carbon\Carbon;
$hasTodayVisit = false;
@endphp

@foreach($kunjungan as $row_kunjungan)
    @if(Carbon::parse($row_kunjungan->kunjungan_tgl)->isToday())
        @php $hasTodayVisit = true; @endphp
        <div class="item">
            <div class="detail">
                <div>
                    <strong>
                        {{-- {{ $row_kunjungan->employees->employees_name }} --}}
                         {{-- {{ tanggal_ind($row_kunjungan->callplan->tanggal_cp) }} {{ $row_kunjungan->callplan->nama_outlet }} --}}
                        @if($row_kunjungan->status_kunjungan == 'Selesai')
                            <span class="badge badge-success">Selesai</span>
                        @elseif($row_kunjungan->status_kunjungan == 'Belum Selesai')
                            <span class="badge badge-danger">Belum Kunjungan</span>
                        @else
                            <span class="badge badge-secondary">UNPLAN</span>
                        @endif
                    </strong>
                    <p>
                        <ion-icon name="calendar-outline"></ion-icon> {{ tanggal_ind($row_kunjungan->kunjungan_tgl) }}<br>
                        <ion-icon name="chatbubble-outline"></ion-icon> {{ $row_kunjungan->description }}
                    </p>
                </div>
            </div>
            <div class="right">
                @php
                $encodedId = epm_encode($row_kunjungan->kunjungan_id);
            @endphp
            
            <a href="{{ route('kunjungan.indexkunjungan', ['kunjungan_id' => $encodedId]) }}">
                <div class="icon-wrapper bg-secondary" style="width: 50px; height: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                        <g fill="none" stroke="white" stroke-width="2">
                            <circle cx="12" cy="13" r="3"/>
                            <path d="M9.778 21h4.444c3.121 0 4.682 0 5.803-.735a4.4 4.4 0 0 0 1.226-1.204c.749-1.1.749-2.633.749-5.697s0-4.597-.749-5.697a4.4 4.4 0 0 0-1.226-1.204c-.72-.473-1.622-.642-3.003-.702c-.659 0-1.226-.49-1.355-1.125A2.064 2.064 0 0 0 13.634 3h-3.268c-.988 0-1.839.685-2.033 1.636c-.129.635-.696 1.125-1.355 1.125c-1.38.06-2.282.23-3.003.702A4.4 4.4 0 0 0 2.75 7.667C2 8.767 2 10.299 2 13.364s0 4.596.749 5.697c.324.476.74.885 1.226 1.204C5.096 21 6.657 21 9.778 21Z"/>
                            <path stroke-linecap="round" d="M19 10h-1"/>
                        </g>
                    </svg>
                </div>
            </a>
            </div>
        </div>
    @endif
@endforeach

@if(!$hasTodayVisit)
    <p class="text-center">Tidak ada data kunjungan untuk hari ini.</p>
@endif
