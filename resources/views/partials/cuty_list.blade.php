@if($cuties->isEmpty())
    <p class="text-center">Tidak ada data cuti untuk periode ini.</p>
@else
    @foreach($cuties as $row_cuty)
        <div class="item">
            <div class="detail">
                <div>
                    <strong>
                        {{ $row_cuty->employees->employees_name }} 
                        @if($row_cuty->cuty_status == '1')
                            <span class="badge badge-success">Disetujui</span>
                        @elseif($row_cuty->cuty_status == '2')
                            <span class="badge badge-danger">Tidak disetujui</span>
                        @else
                            <span class="badge badge-secondary">Menunggu</span>
                        @endif
                    </strong>

                    <p>
                        <ion-icon name="calendar-outline"></ion-icon> {{ tanggal_ind($row_cuty->cuty_start) }} - {{ tanggal_ind($row_cuty->cuty_end) }}<br>
                        <ion-icon name="calendar-outline"></ion-icon> Mulai kerja: {{ tanggal_ind($row_cuty->date_work) }}<br>
                        <ion-icon name="chatbubble-outline"></ion-icon> {{ $row_cuty->cuty_description }}
                    </p>
                </div>
            </div>

            <div class="right">
                @if($row_cuty->cuty_status == '3')
                    <button type="button" class="btn btn-success btn-sm btn-update-cuty" 
                            data-id="{{ $row_cuty->cuty_id }}" 
                            data-start="{{ tanggal_ind($row_cuty->cuty_start) }}" 
                            data-end="{{ tanggal_ind($row_cuty->cuty_end) }}" 
                            data-work="{{ tanggal_ind($row_cuty->date_work) }}" 
                            data-total="{{ $row_cuty->cuty_total }}" 
                            data-description="{{ $row_cuty->cuty_description }}">
                        <i class="fas fa-pencil-alt" aria-hidden="true"></i>
                    </button>
                @else
                    <button type="button" class="btn btn-success btn-sm access-failed">
                        <i class="fas fa-pencil-alt" aria-hidden="true"></i>
                    </button>
                @endif
            </div>
        </div>
    @endforeach
@endif
