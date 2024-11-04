@if($callplan->isEmpty())
    <p class="text-center">Tidak ada data callplan untuk periode ini.</p>
@else
    @foreach($callplan as $row_callplan)
        <div class="item">
            <div class="detail">
                <div>
                    <p>
                        <ion-icon name="calendar-outline"></ion-icon> {{ tanggal_ind($row_callplan->tanggal_cp) }}<br>
                        <ion-icon name="chatbubble-outline"></ion-icon> {{ $row_callplan->description }}
                    </p>
                </div>
            </div>

            <div class="right">
                @if($row_callplan->created_at->diffInDays(now()) < 2)
                <button type="button" class="btn btn-success btn-sm btn-update-callplan" 
                        data-id="{{ $row_callplan->callplan_id }}" 
                        data-start="{{ tanggal_ind($row_callplan->tanggal_cp) }}" 
                        data-outlet="{{ $row_callplan->nama_outlet }}"
                        data-description="{{ $row_callplan->description }}">
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
