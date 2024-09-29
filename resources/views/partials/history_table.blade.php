
{{-- <div class="section-heading mb-1">
    <h2 class="section-title">Presensi Terbaru</h2>
    
</div> --}}
<div class="card mb-1">
    <div class="card-body">
        <form class="search-form">
            <div class="form-group searchbox">
                <input type="text" class="form-control" id="searchInput" placeholder="Cari Presensi">
                <i class="input-icon">
                    <ion-icon name="search-outline"></ion-icon>
                </i>
            </div>
        </form>
    </div>
</div>
@if($absences->isEmpty())
    <p>Tidak ada data presensi untuk periode ini.</p>
@else
@foreach($absences as $index => $absence)
    @php
        $information = $absence->information ? '' . $absence->information : '';
        $presentStatus = $absence->presentStatus;
        $status = $absence->status == 'Telat' ? '<span class="badge badge-danger">' . $absence->status . '</span>' : '<span class="badge badge-success">' . $absence->status . '</span>';
        $status_pulang = $absence->status_pulang == 'Pulang Cepat' ? '<span class="badge badge-danger">' . $absence->status_pulang . '</span>' : '';
    @endphp

    <!-- Tampilkan 3 data pertama secara default -->
    <div class="transactions item {{ $index >= 4 ? 'd-none load-more' : '' }} mb-1" data-name="{{ $presentStatus->present_name }}" data-status="{{ $absence->status }}" data-tanggal="{{ $absence->presence_date }}" data-information="{{ $information }}">
        <div class="item">
            <div class="detail">
                <div>
                    <strong>{{ tgl_ind($absence->presence_date) }} {!! $status !!}</strong>
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <p class="text-dark">Jam Masuk</p>
                            <p class="text-dark">
                                <a class="image-link" href="{{ asset('storage/absent/' . $absence->picture_in) }}">
                                    <span class="badge badge-success">{{ $absence->time_in }}</span>
                                </a>
                            </p>
                        </div>
                        <div class="col-auto">
                            <p class="text-dark">Jam Pulang</p>
                            <p class="text-dark">
                                <a class="image-link" href="{{ asset('storage/absent/' . $absence->picture_out) }}">
                                    <span class="badge badge-success">{{ $absence->time_out }}</span>
                                </a>
                            </p>
                        </div>
                    </div>
                    <p style="padding-left: 8px;"> {{$presentStatus->present_name}} {{$information}}</p>
                </div>
            </div>
            <div class="right">
                {{-- <div class="price text-danger"> - $ 150</div> --}}
                    <button type="button" class="btn btn-success btn-sm modal-update"
                    data-id="{{ $absence->presence_id }}"
                    data-status="{{ $absence->present_id }}"
                    data-information="{{ $absence->information }}"
                    data-date="{{ tgl_ind($absence->presence_date) }}"
                    data-toggle="modal" data-target="#modal-show">
                    <i class="fas fa-pencil-alt"></i>
                    </button>
            </div>
        </div>
    </div>
@endforeach


<div class="section-footer">
    <a href="#" id="loadMoreBtn" class="btn btn-sm btn-block btn-primary">Load More</a>
</div>
<hr>
<div class="transactions mt-1">
    <div class="item">
        <div class="detail row">
            <div class="row-md-auto ml-1">
                <p>Hadir : <span class="badge badge-success">{{ $hadir }}</span></p>
            </div>
            <div class="row-md-auto ml-1">
                <p>Terlambat : <span class="badge badge-danger">{{ $telat }}</span></p>
            </div>
            <div class="row-md-auto ml-1">
                <p>Sakit : <span class="badge badge-warning">{{ $sakit }}</span></p>
            </div>
            <div class="row-md-auto ml-1">
                <p>Izin : <span class="badge badge-info">{{ $izin }}</span></p>
            </div>
        </div>
    </div>
</div>
@endif
<script>
        document.getElementById('searchInput').addEventListener('input', function() {
        let query = this.value.toLowerCase();
        let items = document.querySelectorAll('.transactions.item');

        items.forEach(function(item) {
            let name = item.getAttribute('data-name').toLowerCase();
            let status = item.getAttribute('data-status').toLowerCase();
            let tanggal = item.getAttribute('data-tanggal').toLowerCase();
            let information = item.getAttribute('data-information').toLowerCase();


            if (name.includes(query) || status.includes(query) || tanggal.includes(query) || information.includes(query)) {
                item.style.display = 'block';
            } else {
                item.style.display = 'none';
            }
        });
    });
    // jQuery untuk menampilkan data lebih banyak
    document.getElementById('loadMoreBtn').addEventListener('click', function(event) {
        event.preventDefault();
        document.querySelectorAll('.load-more').forEach(function(el) {
            el.classList.remove('d-none'); // Tampilkan data yang disembunyikan
        });
        this.style.display = 'none'; // Sembunyikan tombol setelah semua data ditampilkan
    });

    // Plugin magnificPopup untuk gambar
    $('.image-link').magnificPopup({type:'image'});
</script>
